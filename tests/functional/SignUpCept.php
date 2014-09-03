<?php 
$I = new FunctionalTester($scenario);

$I->am('a guest');
$I->wantTo('sign up for suenos account');

$I->signUp();

$I->seeCurrentUrlEquals('/profile/foo/edit');
$I->seeRecord('users',[
    'username' => 'foo'
]);

$I->assertTrue(Auth::check());
