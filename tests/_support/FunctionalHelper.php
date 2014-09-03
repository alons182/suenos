<?php
namespace Codeception\Module;
use Laracasts\TestDummy\Factory as TestDummy;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
    public function signIn()
    {
        $email = 'foo@exaple.com';
        $username = 'foo';
        $password = '123';
        $parent_id = null;

        $this->haveAnAccount(compact('email','password','username'));

        $I = $this->getModule('Laravel4');

        $I->amOnPage('/');
        $I->fillField('.login-register input[type="email"]',$email);
        $I->fillField('.login-register input[type="password"]',$password);
        $I->click('Identificarse');
    }

    public function signUp()
    {
        $I = $this->getModule('Laravel4');

        $I->amOnPage('/');
        $I->click('Registrate');
        $I->seeCurrentUrlEquals('/register');

        $I->fillField('.main input[name="username"]','foo');
        $I->fillField('.main input[name="email"]','foo@avotz.com');
        $I->fillField('.main input[name="password"]','demo');
        $I->fillField('.main input[name="password_confirmation"]','demo');
        $I->fillField('Acepta terminos y condiciones:','1');

        $I->click('Crear Cuenta');
    }
    public function updateAProfile($first_name,$last_name,$ide,
                                   $address,$code_zip,$telephone,
                                   $country,$estate,$city,$bank,
                                   $type_account,$number_account,
                                   $nit,$skype)
    {
        $I = $this->getModule('Laravel4');
        $I->fillField('First name:',$first_name);
        $I->fillField('Last name:',$last_name);
        $I->fillField('Identification:',$ide);
        $I->fillField('Address:',$address);
        $I->fillField('Code Zip:',$code_zip);
        $I->fillField('Telephone:',$telephone);
        $I->fillField('Country:',$country);
        $I->fillField('Estate:',$estate);
        $I->fillField('City:',$city);
        $I->fillField('Bank:',$bank);
        $I->fillField('Type Account:',$type_account);
        $I->fillField('Number Account:',$number_account);
        $I->fillField('Nit:',$nit);
        $I->fillField('Skype:',$skype);
        $I->click('Actualizar Perfil');
        //$this->have('Profile',$overrides);
    }
    public function have($model, $overrides = [])
    {
        return TestDummy::create($model,$overrides);
    }

    public function haveAnAccount($overrides =[])
    {
        return $this->have('Suenos\Users\User',$overrides);
    }
}