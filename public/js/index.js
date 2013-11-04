function boxchange( s ){

  if ( s == 1 ) {
    document.getElementById('login').style.display = 'block';
    moveu(0);
  } else {
    document.getElementById('register').style.display = 'block';
    movetd(-35);
  }

  function moveu(n){

    var obj = document.getElementById('innerbox');

    obj.style.marginLeft = -n + "px";
    if ( n <= 289 ) {
      if ( n <= 260 ) {
        n+=10;
      }
      else {
        n+=1;
      }
      setTimeout(function(){moveu(n);},1);
    } else {
      document.getElementById('register').style.display = 'none';
      movetu(0);
    } 

  }

  function moved(n) {

    var obj = document.getElementById('innerbox');

    obj.style.marginLeft = -n + "px";

    if ( n > 0 ) {
      if ( n > 30 ) {
        n-=10;
      }
      else {
        n--;
      }
      setTimeout(function(){moved(n);},1);
    } else {
      document.getElementById('login').style.display = 'none';
    }

  }


  function movetu(nt) {

    var obj = document.getElementById('terms');

    obj.style.marginTop = nt + "px";
    if ( nt > -35 ) {
      nt--;
      setTimeout(function(){movetu(nt);},1);
    }
  }

  function movetd(nt) {
    var obj = document.getElementById('terms');

    obj.style.marginTop = nt + "px";

    if ( nt < 0 ) {
      nt++;
      setTimeout(function(){movetd(nt);},1);
    } else {
      moved( 250 );
    }
  }
}
