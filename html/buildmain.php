<?php include 'realindex.php' ?>
<div id="Right-block-short">
<p>Status as of <?php include 'ref/date.txt' ?>: (updated every 2 hours)<br>
<?php
include 'ref/refstatus.html';
echo '<br>Current Server Load ';
include 'ref/uptime.txt';
echo '    /     ';
include 'ref/nodeuptime.txt';
echo '<br>';
include 'ref/stats.txt';
?>
</div>
  </div>


  </html>

