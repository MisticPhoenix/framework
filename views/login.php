<?php
/** @var $model \App\models\User
 * @var $this \App\View
 * */
$this->title = 'login';
?>

<h1>Create an account</h1>
<form action="" method="post">
    <div class="row">
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
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>