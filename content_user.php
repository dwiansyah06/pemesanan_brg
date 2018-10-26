<table class="table table-hover" id="dataTabel">
<thead>
  <tr>
    <th> Nomor </th>
    <th> Username </th>
    <th> Password </th>
    <th> Level </th>
    <th> Status </th>
  </tr>
</thead>
<tbody>
<?php
include 'config.php';

$result = $mysqli->query("SELECT * FROM user");

if($result){
  $i=1;
  while($obj = $result->fetch_object()) { ?>   
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $obj->username ?></td>
          <td><?php echo $obj->password ?></td>
          <td><?php echo $obj->level ?></td>
          <?php  
            if ($obj->status == 0) {
              echo "<td><p><span class='label label-danger'><i class='fa fa-times mr-5'></i>Offline</span></p></td>";
            } else {
              echo "<td><p><span class='label label-info'><i class='fa fa-circle mr-5' style='color: yellow'></i>Online</span></p></td>";
            }
          ?>
          
        </tr>
<?php  $i++;
  }
}
?>
</tbody>
</table>