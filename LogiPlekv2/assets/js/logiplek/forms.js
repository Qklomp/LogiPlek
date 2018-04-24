$(document).ready(function() 
{  
  $( ".parsley" ).parsley();

  $( ".datepicker" ).datepicker({
    format: "dd-mm-yyyy",
    language: "nl",
    autoclose: true,
    todayHighlight: true,
    keyboardNavigation: false,
  });
});

/* 
 * ==================== BINDINGS ====================
 */

$( ".licenseplate" ).keyup(function() {
  l = $( this ).val().replace("-", "");
  s = GetSidecodeLicenseplate(l);
  $( this ).val(FormatLicenseplate(l,s));
});

$( ".reden" ).click(function() {
  var s = $( ".reden-select" );
  var t = $( ".reden-tekst" );

  if(s.hasClass( "hidden" )) {
    s.removeClass( "hidden" );
    s.attr( "name", "reden" );
    t.addClass( "hidden" );
    t.attr( "name", "" );
    $ ( this ).html( 'zelf invoeren');
  } else if(t.hasClass( "hidden" )) {
    t.removeClass( "hidden" );
    t.attr( "name", "reden" );
    s.addClass( "hidden" );
    s.attr( "name", "" );
    $ ( this ).html( 'selecteren ');
  }
});

$( ".telefoon" ).keyup(function() {
  var oTelNr = new TelNr($( this ).val()); 
  if (oTelNr.validated === true) {
    $( this ).val(oTelNr.toString());
    $( this ).css('border-color', '#cccccc');
    $( this ).next().hide();
  } else {
    $( this ).css('border-color', 'red');
    $( this ).next().html(oTelNr.error);
    $( this ).next().show();
  }
});


/* 
 * ==================== MASKS ====================
 */
 
$( ".postcode" ).focus(function() {
  $(this).mask("9999aa");
});
$( ".srdweek" ).focus(function() {
  $(this).mask("9999");
})
$( ".decimal" ).keyup(function() {
  $(this).val($(this).val().replace(',', '.'));
});

/*
 * ==================== PLUGINS ====================
 */

 function GetSidecodeLicenseplate(Licenseplate)
{
  var arrSC = new Array;
  var scUitz = '';

  Licenseplate = Licenseplate.replace("-", "").toUpperCase();

  arrSC[0] = /^[a-zA-Z]{2}[\d]{2}[\d]{2}$/ // 1 XX-99-99
  arrSC[1] = /^[\d]{2}[\d]{2}[a-zA-Z]{2}$/ // 2 99-99-XX
  arrSC[2] = /^[\d]{2}[a-zA-Z]{2}[\d]{2}$/ // 3 99-XX-99
  arrSC[3] = /^[a-zA-Z]{2}[\d]{2}[a-zA-Z]{2}$/ // 4 XX-99-XX
  arrSC[4] = /^[a-zA-Z]{2}[a-zA-Z]{2}[\d]{2}$/ // 5 XX-XX-99
  arrSC[5] = /^[\d]{2}[a-zA-Z]{2}[a-zA-Z]{2}$/ // 6 99-XX-XX
  arrSC[6] = /^[\d]{2}[a-zA-Z]{3}[\d]{1}$/ // 7 99-XXX-9
  arrSC[7] = /^[\d]{1}[a-zA-Z]{3}[\d]{2}$/ // 8 9-XXX-99
  arrSC[8] = /^[a-zA-Z]{2}[\d]{3}[a-zA-Z]{1}$/ // 9 XX-999-X
  arrSC[9] = /^[a-zA-Z]{1}[\d]{3}[a-zA-Z]{2}$/ // 10 X-999-XX
  arrSC[10] = /^[a-zA-Z]{3}[\d]{2}[a-zA-Z]{1}$/ // 11 XXX-99-X
  arrSC[11] = /^[a-zA-Z]{1}[\d]{2}[a-zA-Z]{3}$/ // 12 X-99-XXX
  arrSC[12] = /^[\d]{1}[a-zA-Z]{2}[\d]{3}$/ // 13 9-XX-999
  arrSC[13] = /^[\d]{3}[a-zA-Z]{2}[\d]{1}$/ // 14 999-XX-9

  //except licenseplates for diplomats
  scUitz = '^CD[ABFJNST][0-9]{1,3}$' //for example: CDB1 of CDJ45

  for(i=0;i<arrSC.length;i++)
  {
    if (Licenseplate.match(arrSC[i])) 
    {
      return i+1;
    }
  }
  if (Licenseplate.match(scUitz)) 
  {
    return 'CD';
  }
  return false;
}

function FormatLicenseplate(Licenseplate,Sidecode) 
{
  Licenseplate = Licenseplate.replace(/-/g, '').toUpperCase();

  if (Sidecode <= 6) 
  {
    return Licenseplate.substr(0, 2) + '-' + Licenseplate.substr(2, 2) + '-' + Licenseplate.substr(4, 2)
  }
  if (Sidecode == 7 || Sidecode == 9) 
  {
    return Licenseplate.substr(0, 2) + '-' + Licenseplate.substr(2, 3) + '-' + Licenseplate.substr(5, 1)
  }
  if (Sidecode == 8 || Sidecode == 10) 
  {
    return Licenseplate.substr(0, 1) + '-' + Licenseplate.substr(1, 3) + '-' + Licenseplate.substr(4, 2)
  }
  if (Sidecode == 11 || Sidecode == 14) 
  {
    return Licenseplate.substr(0, 3) + '-' + Licenseplate.substr(3, 2) + '-' + Licenseplate.substr(5, 1)
  }
  if (Sidecode == 12 || Sidecode == 13) 
  {
    return Licenseplate.substr(0, 1) + '-' + Licenseplate.substr(1, 2) + '-' + Licenseplate.substr(3, 3)
  }
  return Licenseplate
}

/*
 * Validates Dutch phonenumbers and more.
 * Copyright (C) Doeke Zanstra 2001-2009
 * Distributed under the BSD License
 * See http://www.xs4all.nl/~zanstra/dzLib/telNr.htm for more info.
 */
//--| v1.4
//--| Lijst van regionale kengetallen (nummers moeten 10 cijfers hebben)
TelNr.prototype.regio4=',0111,0113,0114,0115,0117,0118,0161,0162,0164,0165,0166,0167,0168,0172,0174,0180,0181,0182,0183,0184,0186,0187,0222,0223,0224,0226,0227,0228,0229,0251,0252,0255,0294,0297,0299,0313,0314,0315,0316,0317,0318,0320,0321,0341,0342,0343,0344,0345,0346,0347,0348,0411,0412,0413,0416,0418,0475,0478,0481,0485,0486,0487,0488,0492,0493,0495,0497,0499,0511,0512,0513,0514,0515,0516,0517,0518,0519,0521,0522,0523,0524,0525,0527,0528,0529,0541,0543,0544,0545,0546,0547,0548,0561,0562,0566,0570,0571,0572,0573,0575,0577,0578,0591,0592,0593,0594,0595,0596,0597,0598,0599,';
TelNr.prototype.regio3=',010,013,015,020,023,024,026,030,033,035,036,038,040,043,045,046,050,053,055,058,070,071,072,073,074,075,076,077,078,079,088';
//--| Kengetallen, niet beschikbaar voor reservering
TelNr.prototype.magNiet4=',0110,0112,0116,0119,0160,0163,0169,0170,0171,0173,0175,0176,0177,0178,0179,0185,0188,0189,0220,0221,0225,0250,0253,0254,0256,0257,0258,0259,0290,0291,0292,0293,0295,0296,0298,0310,0311,0312,0319,0322,0323,0324,0325,0326,0327,0328,0329,0340,0349,0410,0414,0415,0417,0419,0470,0471,0472,0473,0474,0476,0477,0479,0480,0482,0483,0484,0489,0490,0491,0494,0496,0498,0510,0520,0526,0540,0542,0549,0560,0563,0564,0565,0567,0568,0569,0574,0576,0579,0590,06761,06762,06763,06764,06765,06766,06767,06768,06769,0801,0802,0803,0804,0805,0806,0807,0808,0809,0901,0902,0903,0904,0905,0907,0908,';
TelNr.prototype.magNiet3=',012,014,019,021,027,028,037,039,042,060,068,069,081,083,085,086,089,091,092,093,094,095,096,097,098,099,';
//--| 0800,0900,0906 en 0909 nummers kunnen kort (8 tekens) zijn, zoals
//--| vermeldt in onderstaande arrays. Anders zijn ze lang (11 tekens).
TelNr.prototype.infoNrKort=
{ '0800':['00','01','03','04','05','06','07','08','09',
          '10','11','12','13','14','15','16','17','18','19',
          '20','21',
          '41','43','46','49',
          '50','51',
          '60','61',
          '70','71',
          '80','81',
          '90','91']
, '0900':['00','01','02','03','04','05','06','07','08','09',
          '13','14','15','17','18','19',
          '80','81','83','84','86','88',
          '92','93','95','96','97','98']
, '0906':['00','01','02','03','05','06','07','08','09',
          '13','14','15','17','18','19',
          '80','81','83','84','86','88',
          '92','93','95','96','97','98']
, '0909':['00','01','02','03','05','06','07','08','09',
          '13','14','15','17','18','19',
          '80','81','83','84','86','88',
          '92','93','95','96','97','98']
};
TelNr.prototype.landNr=31; //default landen nummer
TelNr.prototype.errors=
[ 'Nummer moet 10 cijfers hebben'
, 'Nummer moet 8 cijfers hebben'
, 'Nummer moet 11 cijfers hebben'
, 'Kengetal is niet beschikbaar voor toekenning of reservering'
, 'Het kengetal is niet herkend'
];
TelNr.prototype.toString=TelNr_toString;

function TelNr(strTelNr) 
{
  var intKengetalStart;
  var intAbonneeNrStart;
  var strKengetal, strSubKengetal;
  
//Zet landennummer
  this.landNr=this.landNr;
//Converteer naar string en verwijder alle non-getallen
  strTelNr=(''+strTelNr).replace(/[^0-9]/g,'');

  if(/^06[1-5]/.test(strTelNr)) 
  {
    //--| mobiel nummer (in 065 zit ook nog een stukje semafonie)
    //--| of internet (06760)
    intKengetalStart=0;
    intAbonneeNrStart=2;
    this.validated=(strTelNr.length==10); //mobile nr should have 10 digits
    if(!this.validated) this.error=this.errors[0];
    this.type='mobiel';
  } 
  else if(/^06760/.test(strTelNr)) 
  {
    //--| mobiel nummer (in 065 zit ook nog een stukje semafonie)
    //--| of internet (06760)
    intKengetalStart=0;
    intAbonneeNrStart=5;
    this.validated=(strTelNr.length==10); //mobile nr should have 10 digits
    if(!this.validated) this.error=this.errors[0];
    this.type='internet';
  } 
  else if(/^08[47]/.test(strTelNr)) 
  {
    //--| Persoonlijke-assistentdiensten (bijv. fax bij KPN fax-in-email/XOIP)
    intKengetalStart=0;
    intAbonneeNrStart=3;
    this.validated=(strTelNr.length==10); //mobile nr should have 10 digits
    if(!this.validated) this.error=this.errors[0];
    this.type='persoonlijke-assistentdiensten';
  } 
  else if(this.infoNrKort[strTelNr.substr(0,4)]) 
  { 
    //--| informatie nummer
    intKengetalStart=0;
    intAbonneeNrStart=4;
    strKengetal=strTelNr.substr(0,4); //eerste 4 cijfers
    strSubKengetal=strTelNr.substr(4,2); //volgende 2 cijfers
    //controleer lengte
    if(this.infoNrKort[strKengetal].exists(strSubKengetal)) 
    {
      this.validated=(strTelNr.length==8);
      if(!this.validated) this.error=this.errors[1];
    }
    else 
    {
      this.validated=(strTelNr.length==11);
      if(!this.validated) this.error=this.errors[2];
    }
    this.type='informatie';
  }
  else if(this.regio3.indexOf(','+strTelNr.substr(0,3)+',')>=0 )
  {
    //--| regionaal nummer, met kort kengetal
    intKengetalStart=0;
    intAbonneeNrStart=3;
    this.validated=(strTelNr.length==10); 
    if(!this.validated) this.error=this.errors[0];
    this.type='regio';
  }
  else if(this.regio4.indexOf(','+strTelNr.substr(0,4)+',')>=0 )
  {
    //--| regionaal nummer, met kort kengetal
    intKengetalStart=0;
    intAbonneeNrStart=4;
    this.validated=(strTelNr.length==10); 
    if(!this.validated) this.error=this.errors[0];
    this.type='regio';
  }
  else if(this.magNiet3.indexOf(','+strTelNr.substr(0,3)+',')>=0 
       || this.magNiet4.indexOf(','+strTelNr.substr(0,4)+',')>=0 )
  {
    intKengetalStart=0;
    intAbonneeNrStart=0;
    this.validated=false;
    this.error=this.errors[3];
    this.type=null;
  }
  else
  {
    //--| onbekend, neem aan dat kengetal 3 cijfers heeft
    intKengetalStart=0;
    intAbonneeNrStart=3;
    this.validated=null;
    this.error=this.errors[4];
    this.type=null;
  }
  this.kengetal=strTelNr.substring(intKengetalStart,intAbonneeNrStart);
  this.abonneeNr=strTelNr.substring(intAbonneeNrStart,strTelNr.length);
  return this;
}

function TelNr_toString()
{
  return this.kengetal+" - "+this.abonneeNr.group(2,2,true," ");
}
/*---Handy methods--*/
Array.prototype.top=function(n) 
{ 
  n=(n||0)+1; 
  return this[this.length-n]||null; 
};
if(!Array.prototype.pop) Array.prototype.pop=function()
{
  var r=this[this.length-1];
  delete this[this.length-1];
  this.length--;
  return r;
}
Array.prototype.exists=Array_exists;
function Array_exists(value) {
  for(var i=0; i<this.length; i++) {
    if(this[i]==value) {
      return true;
    }
  }
  return false;
}
String.prototype.reverse=function() {
  var s='';
  for(var i=this.length-1; i>=0; i--)
  {
    s+=this.charAt(i);
  }
  return s;
}
String.prototype.group=String_group;
function String_group(n1,n2,b,sep)
{
  var re=new RegExp('([0-9]{1,'+n1+'})','g');
  var a, s;
  var ret=[];

  if(typeof n1=='undefined') n1=3;
  if(typeof n2=='undefined') n2=2;
  if(typeof b=='undefined') b=false;
  if(typeof sep=='undefined') sep=' ';
  if(b) s=this.reverse();
  else s=this;
  while(a=re.exec(s))
  {
    ret.push( a[1] );
  }
  if(ret.length>=2 && ret.top().length<n2)
  {
    //zijn er tenminste 2 groepjes en is de lengte van het laatste groepje te kort?
    var k=ret.top(1), l=ret.top(); //één-na-laatste en laatste
    if(parseInt((k.length+l.length)/2,10)>=n2) 
    {
      //2 groepjes maken
      ret[ret.length-1]=ret[ret.length-2].substr(n2)+ret[ret.length-1];
      ret[ret.length-2]=ret[ret.length-2].substring(0,n2);
    }
    else
    {
      //laatste 2 groepjes samenvoegen
      ret[ret.length-2]+=ret.pop();
    }
  }
  if(b) return ret.join(sep).reverse();
  else return ret.join(sep);
}

/*
 * ==================== PLUGIN EXTENSIONS ====================
 */

//          BOOTSTRAP-DATEPICKER

/**
 * Dutch translation for bootstrap-datepicker
 * Reinier Goltstein <mrgoltstein@gmail.com>
 */
;(function($){
  $.fn.datepicker.dates['nl'] = {
    days: ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag", "Zondag"],
    daysShort: ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za", "Zo"],
    daysMin: ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za", "Zo"],
    months: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
    monthsShort: ["Jan", "Feb", "Mrt", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
    today: "Vandaag"
  };
}(jQuery));

//         PARSLEY

// ParsleyConfig definition if not already set
window.ParsleyConfig = window.ParsleyConfig || {};
window.ParsleyConfig.i18n = window.ParsleyConfig.i18n || {};

// Define then the messages
window.ParsleyConfig.i18n.nl = $.extend(window.ParsleyConfig.i18n.nl || {}, {
  defaultMessage: "Deze waarde lijkt onjuist.",
  type: 
  {
    email:      "Dit lijkt geen geldig e-mail adres te zijn.",
    url:        "Dit lijkt geen geldige URL te zijn.",
    urlstrict:  "Dit is geen geldige URL.",
    number:     "Deze waarde moet een nummer zijn.",
    integer:    "Deze waarde moet een nummer zijn.",
    digits:     "Deze waarde moet numeriek zijn.",
    dateIso:    "Deze waarde moet een datum in het volgende formaat zijn: (YYYY-MM-DD).",
    alphanum:   "Deze waarde moet alfanumeriek zijn.",
  },
  notnull:        "Deze waarde mag niet leeg zijn.",
  notblank:       "Deze waarde mag niet leeg zijn.",
  required:       "Dit veld is verplicht.",
  regexp:         "Deze waarde lijkt onjuist te zijn.",
  min:            "Deze waarde mag niet lager zijn dan %s.",
  max:            "Deze waarde mag niet groter zijn dan %s.",
  range:          "Deze waarde moet tussen %s en %s liggen.",
  minlength:      "Deze tekst is te kort. Deze moet uit minimaal %s karakters bestaan.",
  maxlength:      "Deze waarde is te lang. Deze mag maximaal %s karakters lang zijn.",
  rangelength:    "Deze waarde moet tussen %s en %s karakters lang zijn.",
  equalto:        "Deze waardes moeten identiek zijn.",
  minwords:       "Deze waarde moet minstens %s woorden bevatten.",
  maxwords:       "Deze waarde mag maximaal %s woorden bevatten.",
  rangewords:     "Deze waarde moet tussen de %s en %s woorden bevatten.",
  greaterthan:    "Deze waarde moet groter dan %s zijn.",
  lessthan:       "Deze waarde moet kleiner dan %s zijn.",
});

// If file is loaded after Parsley main file, auto-load locale
if ('undefined' !== typeof window.ParsleyValidator)
  window.ParsleyValidator.addCatalog('nl', window.ParsleyConfig.i18n.nl, true);