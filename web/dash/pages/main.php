<div class="page-header">
    <h1>Overview</h1>
</div>
<?php
  $prep = $conn->prepare("SELECT * FROM bots WHERE user_id=:user");
  $prep->bindValue(":user", $_SESSION['user_id'], PDO::PARAM_INT);
  $prep->execute();
  $results = $prep->fetchAll(PDO::FETCH_ASSOC);
  if (empty($results)) {
?><div class="alert alert-info" role="alert">No bots have been added yet. <a href="/dashboard/addbot" class="alert-link">Add a new bot.</a></div><?php
  } else {
?>
<table class="table table-hover">
<caption>My bots - <a href="/dashboard/addbot">Add a new bot.</a></caption>
<thead>
<tr>
<th class="col-xs-4">Bot name</th>
<th class="col-xs-4">Status</th>
<th class="col-xs-4">Actions</th>
</tr>
</thead>
<tbody>
<?php
    foreach ($results as $res) {
      if ($res['active'] == 1) {
        echo "<tr class=\"success\">";
        echo "<td>".$res['name']."</td>";
      } else {
        echo "<tr>";
        echo "<td><a href=\"/dashboard/switch/".$res['id']."/\">".$res['name']."</a></td>";
      }
      if ($status[$res['id']]) {
        echo "<td><span style=\"color:green\"><strong>ONLINE</strong></span>";
      } else {
        echo "<td><span style=\"color:red\"><strong>OFFLINE</strong></span>";
      }
      echo "<td>[<a href=\"/dashboard/editbot/".$res['id']."/\">Edit</a>] [<a href=\"/dashboard/removebot/".$res['id']."/\">Remove</a>]</td>";
      echo "</tr>";
    }
?>
</tbody>
</table>
<?php
  }
?>
