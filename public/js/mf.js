$(document).ready( function() {
    $(".paisal").each(function(i){
    $(this).html( parseFloat( $(this).html()  ) );
    if( !isNaN( $(this).html() ) ) {
                    $(this).html( moneyConvert( $(this).html(), false ) );
            }
    });

    $(".commasep").each(function(i){
        $(this).html( parseFloat( $(this).html()  ) );
        if( !isNaN( $(this).html() ) ) {
            $(this).html( moneyConvert( $(this).html(), false ) );
        }
    });

    $(".paisalinput").each(function(i){
     if( $(this).val() != '' ) {
        $(this).val( parseFloat( $(this).val()  ) );        
        if( !isNaN( $(this).val() ) ) {
            $(this).val( moneyConvert( $(this).val(), false ) );
        }
     }
    });
});


function removeDotsInNumber() {
	$('.removeDots').each(function(){
		if( $(this).html() != '' ) {
			var strVal = $(this).html();
			var arrVal = strVal.split(".");
			$(this).html( arrVal[0] );
		}
	});
}


function moneyConvert( value, isMoney ) {
    value = $.trim( value );
    var buf = "";
    var sBuf = "";
    var j = 0;
    value = String(value);

    if (value.indexOf(".") > 0) {
        buf = value.substring(0, value.indexOf("."));
    } else {
        buf = value;
    }
    if (buf.length % 3 != 0 && (buf.length / 3 - 1) > 0) {
        sBuf = buf.substring(0, buf.length % 3) + ",";
        buf = buf.substring(buf.length % 3);
    }
    j = buf.length;
    for (var i = 0; i < (j / 3 - 1); i++) {
        sBuf = sBuf + buf.substring(0, 3) + ",";
        buf = buf.substring(3);
    }
    sBuf = sBuf + buf;
    if (value.indexOf(".") > 0) {
        value = sBuf + value.substring(value.indexOf("."));
    } else { 
        value = sBuf;
    }
	
	//alert(value.indexOf(".") );
	
	if ( value.indexOf(".") < 0 ) { 
		if( isMoney == true ){
            return value + ".00";
        } else {
            return value;
        }

	} else {
		arrValue = value.split(".");
		if( arrValue[1].length == 2 ) {
			return value;
		} else  {
			return value + "0";
		}
	}
}


    // Convert numbers to words
    // copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
    // permission to use this Javascript on your web page is granted
    // provided that all of the code (including this copyright notice) is
    // used exactly as shown (you can change the numbering system if you wish)

    // American Numbering System
    var th = ['', 'thousand', 'million', 'billion', 'trillion'];
    // uncomment this line for English Number System
    // var th = ['','thousand','million', 'milliard','billion'];
    var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function toWords(s) {
        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s)) return 'not a number';
        var x = s.indexOf('.');
        if (x == -1) x = s.length;
        if (x > 15) return 'too big';
        var n = s.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }
