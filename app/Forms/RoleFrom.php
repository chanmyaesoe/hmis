<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label'    => 'Name',
                'rules'    => 'required|max:100'
            ])
            ->add('code', 'text', [
                'label'    => 'Code',
                'rules'    => 'required|unique:roles|max:100'
            ])
            ->add('description', 'textarea', [
                'label'    => 'Description',
                'rules'    => 'nullable'
            ])
            ->add('register', 'submit', [
                'label' => 'Create Role',
                'attr'  => ['class' => 'btn btn-primary', 'id' => 'create_allowance_btn']
            ]);
    }
}
