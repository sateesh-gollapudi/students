
</body>
<style>
    #footer{
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        padding: 3% 15%; 
        background-color: #7f03fc; 
        color:#fff
    }
    #footer a{
        color: #fff;

    }
    #footer a:hover{
        color: #CCC;

    }
</style>
<!-- Footer -->
<footer class="footer">
    <!-- Copyright -->
    <div class="container">
        <div class="footer-copyright text-center py-3">
            <font>Copyright &copy; <?php echo date('Y'); ?></font>
            <?php $urlfoot = ROOT . 'index.php'; ?>
            <font><a href="<?= $urlfoot; ?>">Student Login</a></font>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
</html>
