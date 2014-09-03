<?php 
$I = new FunctionalTester($scenario);
$I->am('a suenos member');
$I->wantTo('login to my suenos accout');

$I->signIn();

$I->seeCurrentUrlEquals('');
$I->see('Welcome');
