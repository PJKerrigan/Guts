<?php
namespace Guts3\Application\ViewModels;

//  Using declarations.
use Guts3\Application\ViewModel;

class AdminViewModel extends ViewModel {
    
    public function __construct(Model $model) {
        parent::__construct($model);
    }
    
    private function getAdminForm() {
        return
<<<ADMIN_FORM
        <form action="{$_SERVER['PHP_SELF']}" method="post">
            <label for="title">Title</label>
            <input name="title" id="title" type="text" maxlength="150">
            <label for="bodytext">Body Text</label>
            <textarea name="bodytext" id="bodytext"></textarea>
            <input type="submit" value="Create Entry!">
        </form>
ADMIN_FORM;
    }
}