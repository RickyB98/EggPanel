package require http
package require tls
package require json
source scripts/eggpanel.conf

proc eggpanel:loop {args} {
  after 5000 eggpanel:loop    ;# schedule the proc to be executed again after 5 seconds
  global eggpanel
  ::http::register https 443 [list ::tls::socket -tls1 1]
  set token [::http::geturl $eggpanel(api) -query [::http::formatQuery key $eggpanel(key) command fetch]]
  set data [::http::data $token]
  set json [::json::json2dict $data]
  # debug purposes only
  #putlog $json
  foreach {1 2} $json {
    if {$1 eq "code"} {
      switch -nocase $2 {
        200 {}
        default {}
      }
    } elseif {$1 eq "message"} {
      foreach el $2 {
        foreach {3 4} $el {
          switch -nocase $3 {
            id {set action_id $4}
            command {set command $4}
            arguments {set arg $4}
            default {}
          }
        }
      }
    }
  }
  if {[info exists command]} {
    switch -nocase -- $command {
      rehash {eggpanel:rehash $action_id}
      restart {eggpanel:restart $action_id}
      die {eggpanel:die $action_id}
      default {}
    }
  }
}
proc eggpanel:pickup {id success {msg {}}} {
  global eggpanel
  ::http::register https 443 [list ::tls::socket -tls1 1]
  set token [::http::geturl $eggpanel(api) -query [::http::formatQuery key $eggpanel(key) command pickup action $id success $success message $msg]]
}
proc eggpanel:rehash {id} {
  after 1000 rehash
  eggpanel:pickup $id 1 "Rehashing..."
}
proc eggpanel:restart {id} {
  after 1000 restart
  eggpanel:pickup $id 1 "Restarting..."
}
proc eggpanel:die {id} {
  after 1000 die
  eggpanel:pickup $id 1 "Going offline..."
}
if {![info exists eggpanel(start)]} {
  eggpanel:loop
  set eggpanel(start) 1
}

