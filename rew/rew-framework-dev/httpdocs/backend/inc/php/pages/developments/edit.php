 <?php

/* @global Auth $authuser */

 if (!Skin::hasFeature(Skin::REW_DEVELOPMENTS)) {
     throw new \REW\Backend\Exceptions\PageNotFoundException();
 }

// Full width page
    $body_class = 'full';

 // Get Authorization Managers
    $developmentsAuth = new REW\Backend\Auth\DevelopmentsAuth(Settings::getInstance());
 
 // Authorized to Edit all Leads
    if (!$developmentsAuth->canManageDevelopments($authuser)) {
        // Require permission to edit self
        if (!$developmentsAuth->canManageOwnDevelopments($authuser)) {
            throw new \REW\Backend\Exceptions\UnauthorizedPageException(
                'You do not have permission to edit developments.'
            );
        } else {
            // Restrict to owned
            $agent_id = $authuser->info('id');
        }
    }

    // Notices
    $success = array();
    $errors = array();

    // DB connection
    $db = DB::get();

    // Record ID
    $_GET['id'] = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];

    // Locate development record
    $query = $db->prepare("SELECT * FROM `developments` WHERE `id` = ?"
        . ($agent_id ? sprintf(' AND `agent_id` = %d', $agent_id) : '')
        . " LIMIT 1;");
    $query->execute([$_GET['id']]);
    $development = $query->fetch();

 /* Throw Missing Agent Exception */
    if (empty($development)) {
        throw new \REW\Backend\Exceptions\MissingId\MissingDevelopmentException();
    }

        // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['reload'])) {
        try {
            // Slug-ify link URL
            $_POST['link'] = isset($_POST['link']) ? Format::slugify($_POST['link']) : null;

            // Required fields
            $required = [];
            $required['title'] = 'Development Title';
            $required['link'] = 'Development Link';
            foreach ($required as $name => $label) {
                if (empty($_POST[$name])) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s is a required field.',
                        $label
                    ));
                }
            }

            // Require unique link URL
            $query = $db->prepare("SELECT `id` FROM `developments` WHERE `id` != ? AND `link` = ?;");
            $query->execute([$development['id'], $_POST['link']]);
            if ($query->fetchColumn() > 0) {
                throw new \InvalidArgumentException(sprintf(
                    'The link "%s" is already being used.',
                    Format::htmlspecialchars($_POST['link'])
                ));
            }

            // Search criteria
            switch ($_POST['search_criteria']) {
                case 'disabled':
                    $_POST['idx_listings'] = 'N';
                    $_POST['idx_snippet_id'] = 0;
                    break;
                case 'builder':
                    $_POST['idx_listings'] = 'Y';
                    $_POST['idx_snippet_id'] = 0;
                    break;
                case 'snippet':
                    $_POST['idx_listings'] = 'Y';
                    break;
            }

            // Prepare UPDATE query
            $query = $db->prepare("UPDATE `developments` SET "
                // Basics
                . "`link` = :link, "
                . "`title` = :title, "
                . "`subtitle` = :subtitle, "
                . "`description` = :description, "
                . "`community_id` = :community_id, "
                // Display settings
                . "`is_enabled` = :is_enabled, "
                . "`is_featured` = :is_featured, "
                // Property criteria
                . "`idx_feed` = :idx_feed, "
                . "`idx_criteria` = :idx_criteria, "
                . "`idx_listings` = :idx_listings, "
                . "`idx_snippet_id` = :idx_snippet_id, "
                // Meta information
                . "`page_title` = :page_title,"
                . "`meta_description` = :meta_description,"
                . "`about_heading` = :about_heading,"
                // Development Info
                . "`website_url` = :website_url, "
                . "`completion_status` = :completion_status, "
                . "`completion_date` = :completion_date, "
                . "`completion_is_partial` = :completion_is_partial, "
                // Building information
                . "`num_stories` = :num_stories, "
                . "`num_units` = :num_units, "
                . "`unit_min_price` = :unit_min_price, "
                . "`unit_max_price` = :unit_max_price, "
                . "`unit_styles` = :unit_styles, "
                // Building features
                . "`common_features` = :common_features, "
                . "`construction` = :construction, "
                . "`parking` = :parking, "
                . "`views` = :views, "
                // Building address
                . "`address` = :address, "
                . "`city` = :city, "
                . "`state` = :state, "
                . "`zip` = :zip, "
                . "`timestamp_updated` = NOW()"
            . " WHERE `id` = :id;");

            // Execute query
            $query->execute([
                // Basics
                'link' => $_POST['link'],
                'title' => $_POST['title'],
                'subtitle' => $_POST['subtitle'],
                'description' => $_POST['description'],
                'community_id' => $_POST['community_id'] ?: null,
                // Display settings
                'is_enabled' => ($_POST['is_enabled'] === 'Y' ? 'Y' : 'N'),
                'is_featured' => ($_POST['is_featured'] === 'Y' ? 'Y' : 'N'),
                // Property criteria
                'idx_feed' => $_POST['feed'],
                'idx_criteria' => serialize($_POST),
                'idx_listings' => ($_POST['idx_listings'] === 'Y' ? 'Y' : 'N'),
                'idx_snippet_id' => $_POST['idx_snippet_id'] ?: null,
                // Building information
                'website_url' => $_POST['website_url'],
                'completion_status' => $_POST['completion_status'],
                'completion_date' => $_POST['completion_date'],
                'completion_is_partial' => $_POST['completion_is_partial'],
                'num_stories' => $_POST['num_stories'],
                'num_units' => $_POST['num_units'],
                'unit_min_price' => preg_replace('/[^0-9]/', '', $_POST['unit_min_price']),
                'unit_max_price' => preg_replace('/[^0-9]/', '', $_POST['unit_max_price']),
                'unit_styles' => $_POST['unit_styles'],
                // Building features
                'common_features' => $_POST['common_features'],
                'construction' => $_POST['construction'],
                'parking' => $_POST['parking'],
                'views' => $_POST['views'],
                // Address
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip' => $_POST['zip'],
                // Meta information
                'page_title' => $_POST['page_title'],
                'meta_description' => $_POST['meta_description'],
                'about_heading' => $_POST['about_heading'],
                // Development ID
                'id' => $development['id']
            ]);

            try {
                // Prepare query to save assigned tags
                $save_tag = $db->prepare("INSERT INTO `developments_tags` SET "
                    . "`development_id` = ?,"
                    . "`tag_name`       = ?,"
                    . "`tag_order`      = ?,"
                    . "`created_ts`     = NOW()"
                    . " ON DUPLICATE KEY UPDATE "
                    . "`tag_order`      = ?,"
                    . "`updated_ts`     = NOW()"
                . ";");

                // Save assigned tags
                $tags = is_array($_POST['tags']) ? $_POST['tags'] : [];
                if (!empty($tags) && is_array($tags)) {
                    $tag_order = 0;
                    foreach ($tags as $tag_name) {
                        $tag_name = Format::trim($tag_name);
                        if (empty($tag_name)) {
                            continue;
                        }
                        $save_tag->execute([
                            $development['id'],
                            $tag_name,
                            $tag_order,
                            $tag_order
                        ]);
                        $tag_order++;
                    }
                }

                // Delete old tags
                $deleteQuery = "DELETE FROM `developments_tags` WHERE `development_id` = ?%s;";
                $deleteWhereNot = sprintf(" AND `tag_name` NOT IN (%s)", implode(', ', array_fill(0, count($tags), '?')));
                $delete = $db->prepare(sprintf($deleteQuery, !empty($tags) ? $deleteWhereNot : ''));
                $delete->execute(array_merge([$development['id']], $tags));

                // Database error occurred
            } catch (\PDOException $e) {
                $errors[] = 'Error saving tags.';
                //$errors[] = $e->getMessage();
            }

            // Save notices and redirect to back to form
            $success[] = 'Development has successfully been updated.';
            header(sprintf('Location: ?id=%s&success', $development['id']));
            $authuser->setNotices($success, $errors);
            exit;

            // Submission error occurred
        } catch (\InvalidArgumentException $e) {
            $errors[] = $e->getMessage();

            // Database error occurred
        } catch (\PDOException $e) {
            $errors[] = 'Error saving development.';
            $errors[] = $e->getMessage();
        } finally {

            // Use current $_POST data as latest
            foreach ($_POST as $key => $val) {
                if (array_key_exists($key, $development)) {
                    $development[$key] = $val;
                }
            }

        }
    }

        // Load available communities
        $query = $db->query("SELECT `id`, `title` FROM `featured_communities` ORDER BY `title` ASC;");
        $communities = $query->fetchAll();

        // Load development's photos
        $query = $db->prepare("SELECT `id`, `file` FROM `cms_uploads` WHERE `type` = 'development' AND `row` = ? ORDER BY `order`;");
        $query->execute([$development['id']]);
        $uploads = $query->fetchAll();

        // Load development's tags
        $query = $db->prepare("SELECT `tag_name` FROM `developments_tags` WHERE `development_id` = ? ORDER BY `tag_order` ASC;");
        $query->execute([$development['id']]);
        $development['tags'] = $query->fetchAll(PDO::FETCH_COLUMN);

        // Load available tags
        $query = $db->query("SELECT DISTINCT `tag_name` FROM `developments_tags` ORDER BY `tag_name` ASC;");
        $tags = $query->fetchAll(PDO::FETCH_COLUMN);

        // Add selected tags to beginning of list
        $tags = array_unique(array_merge($development['tags'], $tags));

        // Pick IDX feed for development
        $feed = $_POST['feed'] ?: $development['idx_feed'];
    if (!empty($feed)) {
        Util_IDX::switchFeed($feed);
        $idx = Util_IDX::getIdx();
        $db_idx = Util_IDX::getDatabase();
    }

        // IDX Search Criteria
        $criteria = !empty($_POST) ? $_POST : unserialize($development['idx_criteria']);
        $criteria = is_array($criteria) ? $criteria : [];
        $_REQUEST = search_criteria($idx, $criteria);

        // IDX Search Panels
        $panels = isset($_REQUEST['panels']) ? $_REQUEST['panels'] : false;
    if (!is_array($panels)) {
        $panels = ['location' => ['display' => 1]];
    }

        // IDX Builder Panels
        $builder = new IDX_Builder([
            'map' => false,
            'mode' => 'snippet',
            'panels' => $panels,
            'toggle' => false
        ]);

        // Load available IDX snippets
        $query = $db->prepare("SELECT `id`, `name` FROM `snippets` WHERE `type` = 'idx' AND `agent` = ? ORDER BY `name` ASC;");
        $query->execute([$developmentsAuth->canManageDevelopments($authuser) ? 1 : $authuser->info('id')]);
        $idx_snippets = $query->fetchAll();
