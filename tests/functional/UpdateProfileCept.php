<?php 
$I = new FunctionalTester($scenario);
$I->am('suenos member');
$I->wantTo('I want update profile when the user is register');

$I->signUp();

$I->seeCurrentUrlEquals('/profile/foo/edit');
$I->seeRecord('users',[
    'username' => 'foo'
]);

$I->updateAProfile(
    'Foo bar','vamos','vamos','vamos','vamos',
    'vamos','vamos','vamos','vamos','vamos',
    'vamos','vamos','vamos','vamos'
);

$I->seeCurrentUrlEquals('/profile/foo/edit');
$I->see('Profile Updated !');
$I->seeRecord('profiles',[
    'first_name' => 'foo bar',
    'last_name' => 'vamos'
]);
