<?php
/** @var $name string
 * @var $this \App\View
 * */
$this->title = 'profile';
?>
    <h1>Hello, world!</h1>
<?php if (!\App\core\Application::isGuest()): ?>
    <p>and <?php echo $name ?></p>
<?php endif; ?>