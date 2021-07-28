<?php

require_once './bootstrap.inc';


$titles = [
    'YS Web_广濑爱丽丝/広瀬アリス《ヒロインとパーティー!》写真集 Vol.679[58P]',
    'Beautyleg_腿模ChiChi《性感丝袜内衣美腿》 No.1801 写真集[55P]',
    "3D全彩H漫画系列之The Gym无圣光套图[57P]",
    "网络美女_ 一笑芳香沁 - 2B圣诞 写真套图[30P]",
    "秀人网_ No.2561 淼淼小姐姐呀 - 条纹的独特内衣制服系列[39P]",
    "爱丝_佳慧《美丝单车》 写真集[70P]",
    "丝意SIEE_ No.294 婷婷 《停车场的故事》 写真集[49P]",
    "魅妍社_米娅Miya《身材高挑、性感翘臀》 Vol.090 写真集[39P]",
    "YS Web_矢吹春奈《桟桥で待ち合わせ》写真集 Vol.150[72P]",
    "极品萝莉网红咬一口小奈樱你的乳胶小女仆无圣光套图[40P]",
    "纳丝摄影_洋洋《长发长腿清秀美女》 NO.098 写真集[84P]",
    "[亚站撸图]极品女神Stacy Cruz无圣光套图[119P]",
    "魅妍社_网红嫩模@Abby李雅《完美身材女神》 Vol.144 写真集[41P]",
    "丝意SIEE_小月《浓浓春意》 No.269 写真集[29P]",
    "[VGirl]V女郎第11期小艺(孟狐狸)无圣光套图[40P]",
    "丽柜_Model Wendy《黑丝高跟时尚丽人》上下全集 美腿玉足写真图片[59P]",
    "Juicy Honey_ jh057 七海なな Nana Nanaumi 写真集[59P]",
    "Girlz-High_ Mayumi Yamanaka 山中真由美 - 性感内衣 - bgyu_009_001 写真集[45P]",
    "秀人网_周于希Sandy《浴室中的朦胧韵味黑丝内衣》 No.1556 写真集[56P]",
    "Girlz-High_Riina Yoshimi 吉見りぃな #g024 Gravure Gallery 02 写真集[40P]",
    "魅妍社_模特维娜《身材曼妙婀娜别致，肌肤娇嫩若雪》 Vol.278 写真集[42P]",
    "Beautyleg_ NO.1030 Miso 美腿写真集[56P]",
    "动感之星_动感之星ShowTimeDancer 可可 NO.008 写真集[57P]",
    "头条女神_韵竹《风韵佳人》 写真集[21P]",
    "思话_ SH171 苏羽 - 甜美学妹的肉丝[49P]",
    "尤物馆_Luffy菲菲《诱人的蕾丝吊袜兔女郎》 Vol.150 写真集[45P]",
    "尤果圈爱尤物_尹菲《不舍离开的眼睛》 No.1279 写真集[35P]",
    "网络美女_ Kitaro_绮太郎 - 蕾姆运动服[18P]",
    "克拉女神_曼琼《烈焰红唇》 写真集[15P]",
    "NS Eyes_ SF-No.619 Saki Akai 赤井沙希 写真集[20P]",
    "Girlz-High_ Mayumi Yamanaka 山中真由美 - 睡衣系列 - bmay_013_003 写真集[45P]",
    "魅妍社_Olivia童安琪《巨乳新人、丰满美臀》 Vol.087 写真集[43P]",
    "Cosdoki_ 森咲あみ morisakiami_pic_sailor1 写真集[64P]",
    "秀人网_芝芝Booty《办公室主题》 No.1757 写真集[53P]",
    "VYJ_制コレGP ソログラビア Vol.09 Yuui Aoya 青谷优衣 写真集[31P]",
    "Graphis_ NO.463 加美杏奈 《Angel Smile》 写真集[70P]",
    "头条女神_芃芃《黑丝玉足与比基尼》 写真集[25P]",
    "瑞丝馆_李可可《蕾丝镂空半透内衣》 Vol.056 写真集[48P]",
    "Graphis_知花メイサ/知花梅莎 First Gravure 初脱ぎ娘 写真集[62P]",
    "YS Web_广濑爱丽丝/広瀬アリス《ヒロインとパーティー!》写真集 Vol.679[58P]",
    "语画界_ Vol.266 芝芝Booty 《极致丝袜美腿+美尻》 写真集[76P]",
    "尤果圈爱尤物_曼妮儿《蕾丝下的秘密》 NO.871 写真集[40P]",
    "Beautyleg_ NO.605 Jill 美腿写真集[63P]",
    "@misty_ No.170 Mio Suzuki 鈴木美生 写真集[50P]",
    "丽柜_Model 雪儿《白领丽人的诱惑》 上下合集 美腿玉足写真图片[76P]",
    "Beautyleg_黄镫娴Neko《肉丝高叉+黑丝制服》 No.1899 写真集[51P]",
    "[MFStar]模范学院第18期Milk楚楚[42P]",
    "尤蜜荟_Yumi-尤美《衫黑丝OL和泳池湿身》 Vol.044 写真集[50P]",
    "极品萝莉网红我是美少女战士JK酱援交少女无圣光套图[59P]",
    "尤果圈爱尤物_ No.1843 韩妍妍 《白梦情诗》 写真集[35P]",
    "秀人网_ No.2761 张雨萌 - 狂野的豹纹吊裙系列[27P]",
    "Cosdoki_ Ichika Kasagi 笠木いちか kasagiichika_pic_heyagi1[52P]",
    "网络美女_ 斗鱼主播小女巫露娜 - 白色蕾丝长筒[38P]",
    "[亚站撸图]极品女神Martina Mink无圣光套图[120P]",
    "嗲囡囡_新人模特伊蓓Eva 《首套私房》 Vol.021 写真集[56P]",
    "美媛馆_猫本amy《澳大利亚墨尔本归来的美妞~~》 Vol.130 写真集[30P]",
    "Girlz-High_ 一花美沙 Misa Ichibana - ghwb_010_002 写真集[39P]",
    "美媛馆_糯美子Mini《粉色的吊带与透空的内衣系列》 Vol.413 写真集[75P]",
    "尤果圈爱尤物_沐若昕《如沐春风》 No.729 写真集[40P]",
    "网络美女_COS萌妹沧霁桔梗 - 麻衣学姐",
    "头条女神_莫晓希《丝蜜008期众筹回报特别篇-下辑》 写真集[6P]",
    "@misty_ No.270 Saori Yamamoto 山本早織 写真集[60P]",
    "克拉女神_ 西景 《细润の足》 写真集[30P]",
    "Beautyleg_ NO.920 腿模Stephy崔德蓉 美腿写真集[56P]",
    "@misty_ No.216 Yuuri Morishita 森下悠里 写真集[60P]",
    "语画界_ Vol.303 Emily顾奈奈 《浴室上演湿身的淋漓诱惑》 写真集[67P]",
    "丽柜_雪糕&amp;amp;amp;筱筱《姐妹花丝足诱惑》 美腿丝足写真集[80P]",
    "Juicy Honey_ jh108 Kizaki Jessica 希崎ジェシカ/希崎杰西卡 写真集[54P]",
    
    //'Girlz-High_ Mayumi Yamanaka 山中真由美 - 睡衣系列 - bmay_013_003 写真集[45P]',
];

foreach($titles as $title) {
    echo $title . '<br>';
    $a = titleToKeywords($title);
    echo implode(', ', $a) . '<br><br>';
}



//ZDebug::my_print($a);