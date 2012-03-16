<?php

class CountryUtility {
	/**	 
	 * An array of name-value pairs of country codes and countries 
	 * e.g US=>United States of america
	 * @var array
	 */
	public static $countries = 
	array(
"AF"=>"AFGHANISTAN",
"AX"=>"ÅLAND ISLANDS",
"AL"=>"ALBANIA",
"DZ"=>"ALGERIA",
"AS"=>"AMERICAN SAMOA",
"AD"=>"ANDORRA",
"AO"=>"ANGOLA",
"AI"=>"ANGUILLA",
"AQ"=>"ANTARCTICA",
"AG"=>"ANTIGUA AND BARBUDA",
"AR"=>"ARGENTINA",
"AM"=>"ARMENIA",
"AW"=>"ARUBA",
"AU"=>"AUSTRALIA",
"AT"=>"AUSTRIA",
"AZ"=>"AZERBAIJAN",
"BS"=>"BAHAMAS",
"BH"=>"BAHRAIN",
"BD"=>"BANGLADESH",
"BB"=>"BARBADOS",
"BY"=>"BELARUS",
"BE"=>"BELGIUM",
"BZ"=>"BELIZE",
"BJ"=>"BENIN",
"BM"=>"BERMUDA",
"BT"=>"BHUTAN",
"BO"=>"BOLIVIA, PLURINATIONAL STATE OF",
"BQ"=>"BONAIRE, SINT EUSTATIUS AND SABA",
"BA"=>"BOSNIA AND HERZEGOVINA",
"BW"=>"BOTSWANA",
"BV"=>"BOUVET ISLAND",
"BR"=>"BRAZIL",
"IO"=>"BRITISH INDIAN OCEAN TERRITORY",
"BN"=>"BRUNEI DARUSSALAM",
"BG"=>"BULGARIA",
"BF"=>"BURKINA FASO",
"BI"=>"BURUNDI",
"KH"=>"CAMBODIA",
"CM"=>"CAMEROON",
"CA"=>"CANADA",
"CV"=>"CAPE VERDE",
"KY"=>"CAYMAN ISLANDS",
"CF"=>"CENTRAL AFRICAN REPUBLIC",
"TD"=>"CHAD",
"CL"=>"CHILE",
"CN"=>"CHINA",
"CX"=>"CHRISTMAS ISLAND",
"CC"=>"COCOS (KEELING) ISLANDS",
"CO"=>"COLOMBIA",
"KM"=>"COMOROS",
"CG"=>"CONGO",
"CD"=>"CONGO, THE DEMOCRATIC REPUBLIC OF THE",
"CK"=>"COOK ISLANDS",
"CR"=>"COSTA RICA",
"CI"=>"CÔTE D'IVOIRE",
"HR"=>"CROATIA",
"CW"=>"CURAÇAO",
"CU"=>"CUBA",
"CY"=>"CYPRUS",
"CZ"=>"CZECH REPUBLIC",
"DK"=>"DENMARK",
"DJ"=>"DJIBOUTI",
"DM"=>"DOMINICA",
"DO"=>"DOMINICAN REPUBLIC",
"EC"=>"ECUADOR",
"EG"=>"EGYPT",
"SV"=>"EL SALVADOR",
"GQ"=>"EQUATORIAL GUINEA",
"ER"=>"ERITREA",
"EE"=>"ESTONIA",
"ET"=>"ETHIOPIA",
"FK"=>"FALKLAND ISLANDS (MALVINAS)",
"FO"=>"FAROE ISLANDS",
"FJ"=>"FIJI",
"FI"=>"FINLAND",
"FR"=>"FRANCE",
"GF"=>"FRENCH GUIANA",
"PF"=>"FRENCH POLYNESIA",
"TF"=>"FRENCH SOUTHERN TERRITORIES",
"GA"=>"GABON",
"GM"=>"GAMBIA",
"GE"=>"GEORGIA",
"DE"=>"GERMANY",
"GH"=>"GHANA",
"GI"=>"GIBRALTAR",
"GR"=>"GREECE",
"GL"=>"GREENLAND",
"GD"=>"GRENADA",
"GP"=>"GUADELOUPE",
"GU"=>"GUAM",
"GT"=>"GUATEMALA",
"GG"=>"GUERNSEY",
"GN"=>"GUINEA",
"GW"=>"GUINEA-BISSAU",
"GY"=>"GUYANA",
"HT"=>"HAITI",
"HM"=>"HEARD ISLAND AND MCDONALD ISLANDS",
"VA"=>"HOLY SEE (VATICAN CITY STATE)",
"HN"=>"HONDURAS",
"HK"=>"HONG KONG",
"HU"=>"HUNGARY",
"IS"=>"ICELAND",
"IN"=>"INDIA",
"ID"=>"INDONESIA",
"IR"=>"IRAN, ISLAMIC REPUBLIC OF",
"IQ"=>"IRAQ",
"IE"=>"IRELAND",
"IM"=>"ISLE OF MAN",
"IL"=>"ISRAEL",
"IT"=>"ITALY",
"JM"=>"JAMAICA",
"JP"=>"JAPAN",
"JE"=>"JERSEY",
"JO"=>"JORDAN",
"KZ"=>"KAZAKHSTAN",
"KE"=>"KENYA",
"KI"=>"KIRIBATI",
"KP"=>"KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF",
"KR"=>"KOREA, REPUBLIC OF",
"KW"=>"KUWAIT",
"KG"=>"KYRGYZSTAN",
"LA"=>"LAO PEOPLE'S DEMOCRATIC REPUBLIC",
"LV"=>"LATVIA",
"LB"=>"LEBANON",
"LS"=>"LESOTHO",
"LR"=>"LIBERIA",
"LY"=>"LIBYA",
"LI"=>"LIECHTENSTEIN",
"LT"=>"LITHUANIA",
"LU"=>"LUXEMBOURG",
"MO"=>"MACAO",
"MK"=>"MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
"MG"=>"MADAGASCAR",
"MW"=>"MALAWI",
"MY"=>"MALAYSIA",
"MV"=>"MALDIVES",
"ML"=>"MALI",
"MT"=>"MALTA",
"MH"=>"MARSHALL ISLANDS",
"MQ"=>"MARTINIQUE",
"MR"=>"MAURITANIA",
"MU"=>"MAURITIUS",
"YT"=>"MAYOTTE",
"MX"=>"MEXICO",
"FM"=>"MICRONESIA, FEDERATED STATES OF",
"MD"=>"MOLDOVA, REPUBLIC OF",
"MC"=>"MONACO",
"MN"=>"MONGOLIA",
"ME"=>"MONTENEGRO",
"MS"=>"MONTSERRAT",
"MA"=>"MOROCCO",
"MZ"=>"MOZAMBIQUE",
"MM"=>"MYANMAR",
"NA"=>"NAMIBIA",
"NR"=>"NAURU",
"NP"=>"NEPAL",
"NL"=>"NETHERLANDS",
"NC"=>"NEW CALEDONIA",
"NZ"=>"NEW ZEALAND",
"NI"=>"NICARAGUA",
"NE"=>"NIGER",
"NG"=>"NIGERIA",
"NU"=>"NIUE",
"NF"=>"NORFOLK ISLAND",
"MP"=>"NORTHERN MARIANA ISLANDS",
"NO"=>"NORWAY",
"OM"=>"OMAN",
"PK"=>"PAKISTAN",
"PW"=>"PALAU",
"PS"=>"PALESTINIAN TERRITORY, OCCUPIED",
"PA"=>"PANAMA",
"PG"=>"PAPUA NEW GUINEA",
"PY"=>"PARAGUAY",
"PE"=>"PERU",
"PH"=>"PHILIPPINES",
"PN"=>"PITCAIRN",
"PL"=>"POLAND",
"PT"=>"PORTUGAL",
"PR"=>"PUERTO RICO",
"QA"=>"QATAR",
"RE"=>"RÉUNION",
"RO"=>"ROMANIA",
"RU"=>"RUSSIAN FEDERATION",
"RW"=>"RWANDA",
"BL"=>"SAINT BARTHÉLEMY",
"SH"=>"SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA",
"KN"=>"SAINT KITTS AND NEVIS",
"LC"=>"SAINT LUCIA",
"MF"=>"SAINT MARTIN (FRENCH PART)",
"PM"=>"SAINT PIERRE AND MIQUELON",
"VC"=>"SAINT VINCENT AND THE GRENADINES",
"WS"=>"SAMOA",
"SM"=>"SAN MARINO",
"ST"=>"SAO TOME AND PRINCIPE",
"SA"=>"SAUDI ARABIA",
"SN"=>"SENEGAL",
"RS"=>"SERBIA",
"SC"=>"SEYCHELLES",
"SL"=>"SIERRA LEONE",
"SG"=>"SINGAPORE",
"SX"=>"SINT MAARTEN (DUTCH PART)",
"SK"=>"SLOVAKIA",
"SI"=>"SLOVENIA",
"SB"=>"SOLOMON ISLANDS",
"SO"=>"SOMALIA",
"ZA"=>"SOUTH AFRICA",
"GS"=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
"SS"=>"SOUTH SUDAN",
"ES"=>"SPAIN",
"LK"=>"SRI LANKA",
"SD"=>"SUDAN",
"SR"=>"SURINAME",
"SJ"=>"SVALBARD AND JAN MAYEN",
"SZ"=>"SWAZILAND",
"SE"=>"SWEDEN",
"CH"=>"SWITZERLAND",
"SY"=>"SYRIAN ARAB REPUBLIC",
"TW"=>"TAIWAN, PROVINCE OF CHINA",
"TJ"=>"TAJIKISTAN",
"TZ"=>"TANZANIA, UNITED REPUBLIC OF",
"TH"=>"THAILAND",
"TL"=>"TIMOR-LESTE",
"TG"=>"TOGO",
"TK"=>"TOKELAU",
"TO"=>"TONGA",
"TT"=>"TRINIDAD AND TOBAGO",
"TN"=>"TUNISIA",
"TR"=>"TURKEY",
"TM"=>"TURKMENISTAN",
"TC"=>"TURKS AND CAICOS ISLANDS",
"TV"=>"TUVALU",
"UG"=>"UGANDA",
"UA"=>"UKRAINE",
"AE"=>"UNITED ARAB EMIRATES",
"GB"=>"UNITED KINGDOM",
"US"=>"UNITED STATES",
"UM"=>"UNITED STATES MINOR OUTLYING ISLANDS",
"UY"=>"URUGUAY",
"UZ"=>"UZBEKISTAN",
"VU"=>"VANUATU",
"VE"=>"VENEZUELA, BOLIVARIAN REPUBLIC OF",
"VN"=>"VIET NAM",
"VG"=>"VIRGIN ISLANDS, BRITISH",
"VI"=>"VIRGIN ISLANDS, U.S.",
"WF"=>"WALLIS AND FUTUNA",
"EH"=>"WESTERN SAHARA",
"YE"=>"YEMEN",
"ZM"=>"ZAMBIA",
"ZW"=>"ZIMBABWE",

);

	/**	 
	 * International calling codes for countries
	 * @var array
	 */
	public static $intl_code = array(
'PR'=>'1',
'US'=>'1',
'CA'=>'1',
'KZ'=>'7',
'RU'=>'7',
'EG'=>'20',
'ZA'=>'27',
'GR'=>'30',
'NL'=>'31',
'BE'=>'32',
'FR'=>'33',
'ES'=>'34',
'HU'=>'36',
'IT'=>'39',
'VA'=>'39',
'RO'=>'40',
'CH'=>'41',
'AT'=>'43',
'IM'=>'44',
'GB'=>'44',
'DK'=>'45',
'SE'=>'46',
'NO'=>'47',
'PL'=>'48',
'DE'=>'49',
'PE'=>'51',
'MX'=>'52',
'CU'=>'53',
'AR'=>'54',
'BR'=>'55',
'CL'=>'56',
'CO'=>'57',
'VE'=>'58',
'MY'=>'60',
'AU'=>'61',
'CC'=>'61',
'CX'=>'61',
'ID'=>'62',
'PH'=>'63',
'NZ'=>'64',
'SG'=>'65',
'TH'=>'66',
'JP'=>'81',
'KP'=>'82',
'VN'=>'84',
'CN'=>'86',
'TR'=>'90',
'IN'=>'91',
'PK'=>'92',
'AF'=>'93',
'LK'=>'94',
'MM'=>'95',
'IR'=>'98',
'MA'=>'212',
'DZ'=>'213',
'TN'=>'216',
'LY'=>'218',
'GM'=>'220',
'SN'=>'221',
'MR'=>'222',
'ML'=>'223',
'GN'=>'224',
'CI'=>'225',
'BF'=>'226',
'NE'=>'227',
'TG'=>'228',
'BJ'=>'229',
'MU'=>'230',
'LR'=>'231',
'SL'=>'232',
'GH'=>'233',
'NG'=>'234',
'TD'=>'235',
'CF'=>'236',
'CM'=>'237',
'CV'=>'238',
'ST'=>'239',
'GQ'=>'240',
'GA'=>'241',
'CG'=>'242',
'CD'=>'243',
'AO'=>'244',
'GW'=>'245',
'SC'=>'248',
'SD'=>'249',
'RW'=>'250',
'ET'=>'251',
'SO'=>'252',
'DJ'=>'253',
'KE'=>'254',
'TZ'=>'255',
'UG'=>'256',
'BI'=>'257',
'MZ'=>'258',
'ZM'=>'260',
'MG'=>'261',
'YT'=>'262',
'ZW'=>'263',
'NA'=>'264',
'MW'=>'265',
'LS'=>'266',
'BW'=>'267',
'KM'=>'269',
'SH'=>'290',
'ER'=>'291',
'AW'=>'297',
'FO'=>'298',
'GL'=>'299',
'GI'=>'350',
'PT'=>'351',
'LU'=>'352',
'IE'=>'353',
'IS'=>'354',
'AL'=>'355',
'MT'=>'356',
'CY'=>'357',
'FI'=>'358',
'BG'=>'359',
'LT'=>'370',
'LV'=>'371',
'EE'=>'372',
'MD'=>'373',
'AM'=>'374',
'BY'=>'375',
'AD'=>'376',
'MC'=>'377',
'SM'=>'378',
'UA'=>'380',
'RS'=>'381',
'ME'=>'382',
'HR'=>'385',
'SI'=>'386',
'BA'=>'387',
'MK'=>'389',
'CZ'=>'420',
'SK'=>'421',
'LI'=>'423',
'FK'=>'500',
'BZ'=>'501',
'GT'=>'502',
'SV'=>'503',
'HN'=>'504',
'NI'=>'505',
'CR'=>'506',
'PA'=>'507',
'PM'=>'508',
'HT'=>'509',
'BL'=>'590',
'BO'=>'591',
'GY'=>'592',
'EC'=>'593',
'PY'=>'595',
'SR'=>'597',
'UY'=>'598',
'AN'=>'599',
'TL'=>'670',
'NF'=>'672',
'AQ'=>'672',
'BN'=>'673',
'NR'=>'674',
'PG'=>'675',
'TO'=>'676',
'SB'=>'677',
'VU'=>'678',
'FJ'=>'679',
'PW'=>'680',
'WF'=>'681',
'CK'=>'682',
'NU'=>'683',
'WS'=>'685',
'KI'=>'686',
'NC'=>'687',
'TV'=>'688',
'PF'=>'689',
'TK'=>'690',
'FM'=>'691',
'MH'=>'692',
'KR'=>'850',
'HK'=>'852',
'MO'=>'853',
'KH'=>'855',
'LA'=>'856',
'PN'=>'870',
'BD'=>'880',
'TW'=>'886',
'MV'=>'960',
'LB'=>'961',
'JO'=>'962',
'SY'=>'963',
'IQ'=>'964',
'KW'=>'965',
'SA'=>'966',
'YE'=>'967',
'OM'=>'968',
'AE'=>'971',
'IL'=>'972',
'BH'=>'973',
'QA'=>'974',
'BT'=>'975',
'MN'=>'976',
'NP'=>'977',
'TJ'=>'992',
'TM'=>'993',
'AZ'=>'994',
'GE'=>'995',
'KG'=>'996',
'UZ'=>'998',
'BS'=>'1242',
'BB'=>'1246',
'AI'=>'1264',
'AG'=>'1268',
'VG'=>'1284',
'VI'=>'1340',
'KY'=>'1345',
'BM'=>'1441',
'GD'=>'1473',
'MF'=>'1599',
'TC'=>'1649',
'MS'=>'1664',
'MP'=>'1670',
'GU'=>'1671',
'AS'=>'1684',
'LC'=>'1758',
'DM'=>'1767',
'VC'=>'1784',
'DO'=>'1809',
'TT'=>'1868',
'KN'=>'1869',
'JM'=>'1876',
			);	
		

	
}

?>