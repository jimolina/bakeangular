<div class="login">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <h1 class="title-section"><?= __('Login') ?></h1>
        <?= $this->Form->control('username', ['label' => false, 'placeholder' => 'Username', 'maxlength' => '10', 'required' => true]) ?>
        <?= $this->Form->password('password', ['label' => false, 'placeholder' => 'Password', 'maxlength' => '15', 'minlength' => '6', 'required' => true]) ?>
    </fieldset>
<?= $this->Form->button(__('Go'), ['class' => 'btn btn-primary']); ?>
<?= $this->Form->end() ?>
</div>