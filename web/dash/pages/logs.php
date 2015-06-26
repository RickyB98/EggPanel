<?php
if (!isset($_SESSION['bot_id'])) {
  $nobot = true;
} else {
  $prep = $conn->prepare("SELECT * FROM actions WHERE bot_id=:botid ORDER BY id DESC");
  $prep->bindValue(":botid", $_SESSION['bot_id'], PDO::PARAM_INT);
  $prep->execute();
  $results = array_slice($prep->fetchAll(PDO::FETCH_ASSOC), 0, 30);
}
?>
<div class="page-header">
<h1>Logs</h1>
</div>
<?php if (isset($nobot)) { ?>
<div class="alert alert-info" role="alert">No bots have been added yet. <a class="alert-link" href="/dashboard/addbot">Add a new bot.</a></div>
<?php } else { ?>
<table class="table table-hover table-bordered">
<thead>
<tr>
<th>Action</th>
<th>Arguments</th>
<th>Timestamp</th>
<th>Picked up?</th>
<th>Time of pick up</th>
<th>Success?</th>
<th>Message</th>
</thead>
<tbody>
<?php foreach ($results as $res) {
  echo "<tr>";
  echo "<td>".$res['command']."</td>";
  if (is_null($res['arguments'])) {
    echo "<td>---</td>";
  } else {
    echo "<td>".$res['arguments']."</td>";
  }
  echo "<td>".date("D M j G:i:s T Y", $res['timestamp'])."</td>";
  if ($res['executed'] === "1") {
    echo "<td><span class=\"glyphicon glyphicon-ok\" style=\"color:green\" aria-hidden=\"true\"></span></td>";
    echo "<td>".date("D M j G:i:s T Y", $res['pickup'])."</td>";
  } else {
    echo "<td><span class=\"glyphicon glyphicon-remove\" style=\"color:red\" aria-hidden=\"true\"></span></td>";
    echo "<td></td>";
  }
  if ($res['success'] === "1") {
    echo "<td><span class=\"glyphicon glyphicon-ok\" style=\"color:green\" aria-hidden=\"true\"></span></td>";
  } elseif ($res['success'] === "0") {
    echo "<td><span class=\"glyphicon glyphicon-remove\" style=\"color:red\" aria-hidden=\"true\"></span></td>";
  } else {
    echo "<td></td>";
  }
  echo "<td>".htmlspecialchars($res['message'])."</td>";
  echo "</tr>";
}
?>
</tbody>
</table>
<?php } ?>

