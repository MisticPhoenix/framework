<?php
/** @var $model \App\models\User
 * @var $this \App\View
 * */
$this->title = 'register';
?>

<h1>Create an account</h1>
<form action="" method="post">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $model->firstName; ?>" class="form-control
                    <?php echo $model->hasError('firstName') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError('firstName') ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?php echo $model->lastName; ?>" class="form-control
                    <?php echo $model->hasError('lastName') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError('lastName') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input name="email" value="<?php echo $model->email; ?>" class="form-control
            <?php echo $model->hasError('email') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?php echo $model->getFirstError('email') ?>
        </div>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $model->password; ?>" class="form-control
            <?php echo $model->hasError('password') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?php echo $model->getFirstError('password') ?>
        </div>
    </div>
    <div class="mb-3">
        <label>Confirm password</label>
        <input name="confirmPassword" value="<?php echo $model->confirmPassword; ?>" class="form-control
            <?php echo $model->hasError('confirmPassword') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?php echo $model->getFirstError('confirmPassword') ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>