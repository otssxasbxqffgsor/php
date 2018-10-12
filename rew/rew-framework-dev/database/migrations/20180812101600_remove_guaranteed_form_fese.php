<?php

use Phinx\Migration\AbstractMigration;

class RemoveGuaranteedFormFese extends AbstractMigration
{

    protected $form = '<form action="?submit" method="post" class="uk-form uk-form-stacked">
    <input type="hidden" name="guaranteedsoldform" value="true">
    <input type="text" name="registration_type" style="display: none;" tabindex="-1" autocomplete="off">
     
      <div class="uk-width-large-1-1 uk-width-small-1-1 uk-text-left">
      <h1>Guaranteed Sold</h1>
      <h4>Fill out the form below to apply for our Guaranteed Sold program:</h4>
      </div>

    <div class="uk-grid">
    
        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">First Name</label>
            <input name="onc5khko" value="" class="uk-width-1-1 uk-form-large" required>
        </div>
    
        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">Last Name</label>
            <input name="sk5tyelo" value="" class="uk-width-1-1 uk-form-large" required>
        </div>

        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">Email</label>
            <input type="email" name="mi0moecs" value="" class="uk-width-1-1 uk-form-large" required>
            <p class="uk-form-help-block uk-text-muted">Please provide a valid email address.</p>
        </div>
    
        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">Phone <small>(optional)</small></label>
            <input type="tel" name="telephone" value="" class="uk-width-1-1 uk-form-large">
        </div>

        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">Address</label>
            <input type="text" name="fm-addr" value="" class="uk-width-1-1 uk-form-large" required>
        </div>
    
        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">City</label>
            <input type="text" name="fm-town" value="" class="uk-width-1-1 uk-form-large" required>
        </div>
  
         <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">State</label>
            <input type="text" name="fm-state" value="" class="uk-width-1-1 uk-form-large" required>
        </div>
    
        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <label class="uk-form-label">Zip Code</label>
            <input type="text" name="fm-postcode" value="" class="uk-width-1-1 uk-form-large" required>
        </div>

          <div class="uk-width-large-1-1 uk-width-small-1-1 uk-text-left uk-margin-top uk-margin-bottom">
             <label class="uk-form-label">Property Information</label>
          </div>
      
            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>Number of Bedrooms</label> <select name="bedrooms">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7+">7+</option>
            </select>
            </div>

           <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>Number of Bathrooms</label> <select name="bathrooms">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7+">7+</option>
            </select>
            </div>

            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>Square Feet</label> <select name="square_feet">
                <option value="Less than 1000">&lt; 1000</option>
                <option value="1000 - 1500">1000 - 1500</option>
                <option value="1500 - 2000">1500 - 2000</option>
                <option value="2000 - 2500">2000 - 2500</option>
                <option value="2500 - 3000">2500 - 3000</option>
                <option value="3000 - 3500">3000 - 3500</option>
                <option value="3500 - 4000">3500 - 4000</option>
                <option value="4000 - 4500">4000 - 4500</option>
                <option value="4500 - 5000">4500 - 5000</option>
                <option value="5000 - 6000">5000 - 6000</option>
                <option value="6000 - 7000">6000 - 7000</option>
                <option value="7000 - 8000">7000 - 8000</option>
                <option value="8000 - 9000">8000 - 9000</option>
                <option value="9000 - 10,000">9000 - 10,000</option>
                <option value="10,000 +">10,000 +</option>
            </select>
            </div>

            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>Property Type</label> <select name="type_of_property">
                <option value="house">House</option>
                <option value="condo">Condo</option>
                <option value="land">Land</option>
                <option value="townhome">Townhome</option>
            </select>
            </div>

            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>Price Range</label> <select name="price_range">
                <option value="Less than $300,000">Less than $300,000</option>
                <option value="$300,000 - $500,000">$300,000 - $500,000</option>
                <option value="$500,000 - $700,000">$500,000 - $700,000</option>
                <option value="$700,000 - $900,000">$700,000 - $900,000</option>
                <option value="$900,000 - $1,000,000">$900,000 - $1,000,000</option>
                <option value="$1,000,000 - $2,000,000">$1,000,000 - $2,000,000</option>
                <option value="$1,000,000 - $2,000,000">$1,000,000 - $2,000,000</option>
                <option value="$2,000,000 - $3,000,000">$2,000,000 - $3,000,000</option>
                <option value="$3,000,000 - $4,000,000">$3,000,000 - $4,000,000</option>
                <option value="$4,000,000 - $5,000,000">$4,000,000 - $5,000,000</option>
                <option value="Over $5,000,000">Over $5,000,000</option>
            </select>
            </div>

            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2 uk-margin-top uk-margin-bottom">
            <label>When do you plan to sell?</label> <select name="when_do_you_plan_to_sell">
                <option value="3 Months">3 Months</option>
                <option value="6 Months">6 Months</option>
                <option value="9 Months">9 Months</option>
                <option value="1 Year">1 Year</option>
                <option value="1 Year+">1 Year+</option>
            </select>
            </div>

          <div class="uk-width-1-1 uk-margin-top uk-margin-bottom">
            <label class="uk-form-label">Additional Information</label>
            <textarea cols="32" rows="6" name="comments" class="uk-width-1-1 uk-form-large"></textarea>
        </div>
    
        <div class="uk-width-1-1 uk-margin-bottom">
            <div class="uk-form-controls uk-form-controls-text uk-margin">
                <p class="uk-form-controls-condensed">
                {opt_in}
                </p>
            </div>
        </div>

        <div class="uk-form-row">
            <button type="submit" class="uk-button uk-button-medium">Submit Form</button>
        </div>

    </div>
</form>';

    /**
     * Remove guaranteed sale form
     * @return void
     */
    public function up()
    {
        $this->execute("DELETE FROM `snippets` WHERE `name` = 'form-guarenteed';");
    }

    /**
     * Add guaranteed sale form
     * @return void
     */
    public function down()
    {
        $table = $this->table('snippets');
        $table
            ->insert([
                'agent' => null,
                'name' => 'form-guaranteed',
                'code' => $this->form,
                'type' => 'form'
            ])
            ->saveData();
    }
}