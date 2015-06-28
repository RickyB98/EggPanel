package require http
package require tls
package require json
source scripts/eggpanel.conf

proc eggpanel:loop {args} {
  global eggpanel
  ::http::register https 443 [list ::tls::socket -tls1 1]
  set token [::http::geturl $eggpanel(api) -query [::http::formatQuery key $eggpanel(key) command fetch]]
  set data [::http::data $token]
  set json [::json::json2dict $data]
  # debug purposes only
  #putlog $json
  #
  #
  if {[dict exists $json code]} {
    switch -nocase -- [dict get $json code] {
      200 {}
      default {}
    }
  }
  if {[dict exists $json message]} {
    foreach msg [dict get $json message] {
      dict with msg {
        switch -nocase -- $command {
          rehash {eggpanel:rehash $id}
          restart {eggpanel:restart $id}
          die {eggpanel:die $id}
          default {}
        }
      }
    }
  }
  after 5000 eggpanel:loop    ;# schedule the proc to be executed again after 5 seconds
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

