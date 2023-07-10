<?php
require('../../bootstrap.inc.php');

$dirs = <<<EOF
美媛馆_Abby王乔恩《3套内衣-湿身》-Vol.202-写真集-35P-
美媛馆_AngelaLee李玲-Vol.005-写真集-54P-
美媛馆_Angela喜欢猫《丰润迷人的性感内衣私房》-Vol.334-写真集-45P-
美媛馆_Angela喜欢猫《古典韵味旗袍-现代性感黑丝》-Vol.326-写真集-40P-
美媛馆_Angela小热巴《丰润迷人的美臀极度诱惑》-Vol.322-写真集-54P-
美媛馆_Anna徐子琦《三亚旅拍》清新外拍-Vol.044-写真集-54P-
美媛馆_Anna徐子琦《三亚旅拍》福利篇-Vol.056-写真集-75P-
美媛馆_Anna徐子琦《透视装的诱惑》-Vol.025-写真集-50P-
美媛馆_Barbie可儿《三亚旅拍三套合集-》-Vol.013-写真集-158P-
美媛馆_Barbie可儿《泰国旅拍-3-4合集》-Vol.026-写真集-109P-
美媛馆_Barbie可儿《泰国旅拍合集一》-Vol.016-写真集-109P-
美媛馆_Betty林子欣《性感的内衣户外拍摄系列》-Vol.392-写真集-65P-
美媛馆_Betty林子欣《若有若无的半透内衣极致诱惑》-Vol.382-写真集-52P-
美媛馆_Cris_卓娅祺《大尺度惹火曲线》-Vol.298-写真集-53P-
美媛馆_Cris_卓娅祺《性感丝袜》-Vol.304-写真集-29P-
美媛馆_Ellie艾栗栗《水手服私房诱惑》-Vol.184-写真集-27P-
美媛馆_Evelyn艾莉《大胆比基尼湿身外拍》-Vol.186-写真集-58P-
美媛馆_Evelyn艾莉《性感女仆装》-Vol.157-写真集-44P-
美媛馆_Evelyn艾莉《死库水-泳装外拍》-Vol.175-写真集-73P-
美媛馆_Evelyn艾莉《泳池湿身》-Vol.180-写真集-50P-
美媛馆_Evelyn艾莉《猫耳妹子》-Vol.163-写真集-63P-
美媛馆_Evelyn艾莉《白丝袜日系少女》-Vol.150-写真集-50P-
美媛馆_Evelyn艾莉《衬衫-校服诱惑》-Vol.153-写真集-49P-
美媛馆_Evelyn艾莉《迷你短裙诱惑-白丝旗袍》-Vol.173-写真集-93P-
美媛馆_Evelyn艾莉《高叉死库水-黑丝吊袜》-Vol.166-写真集-62P-
美媛馆_Evelyn艾莉《黑丝吊袜-泳池湿身》-Vol.170-写真集-53P-
美媛馆_Fiona伊雨蔓《2套性感内衣》-Vol.054-写真集-55P-
美媛馆_Fiona伊雨蔓---短发比基尼妹子-Vol.040-写真集-37P-
美媛馆_Flower朱可儿《华丽不失性感的内衣系列》-Vol.397-写真集-49P-
美媛馆_Flower朱可儿《呼之欲出的美胸屏霸》-Vol.363-写真集-61P-
美媛馆_Flower朱可儿《性感三点式奶牛内衣系列》-Vol.370-写真集-63P-
美媛馆_Flower朱可儿《性感内衣与真空蕾丝网袜》-Vol.364-写真集-44P-
美媛馆_Flower朱可儿《性感女仆系列》-Vol.408-写真集-49P-
美媛馆_Flower朱可儿《性感血滴子内衣系列》-Vol.412-写真集-44P-
美媛馆_Flower朱可儿《情趣内衣与浴室系列》-Vol.400-写真集-41P-
美媛馆_Flower朱可儿《情趣内衣与浴缸系列》-Vol.409-写真集-75P-
美媛馆_Flower朱可儿《户外凹凸别致的性感身材》-Vol.373-写真集-62P-
美媛馆_Flower朱可儿《户外学院风学生装系列》-Vol.394-写真集-54P-
美媛馆_Flower朱可儿《拳击少女尤物》-Vol.361-写真集-79P-
美媛馆_Flower朱可儿《捆绑诱惑》-Vol.366-写真集-88P-
美媛馆_Flower朱可儿《日本旅拍蕾丝内衣系列》-Vol.389-写真集-133P-
美媛馆_Flower朱可儿《时隔四年朱可儿》-Vol.357-写真集-99P-
美媛馆_Flower朱可儿《浴室系列》-Vol.393-写真集-15P-
美媛馆_Flower朱可儿《清新可人又不是性感魅惑的服饰系列》-Vol.360-写真集-58P-
美媛馆_Flower朱可儿《秘书黑丝眼镜OL系列》-Vol.368-写真集-99P-
美媛馆_Flower朱可儿《粉色的性感内衣与蕾丝网袜》-Vol.365-写真集-42P-
美媛馆_Flower朱可儿《精彩合集套图（上部）》-Vol.384-写真集-70P-
美媛馆_Flower朱可儿《精致镂空不失诱人之处的蕾丝内衣系列》-Vol.383-写真集-70P-
美媛馆_Flower朱可儿《精致镂空情趣内衣与筒袜系列》-Vol.403-写真集-40P-
美媛馆_Flower朱可儿《肉丝袜的真空美腿翘臀》-Vol.388-写真集-38P-
美媛馆_Flower朱可儿《蕾丝包裹下美臀》-Vol.387-写真集-71P-
美媛馆_Flower朱可儿《越南旅拍》-Vol.367-写真集-56P-
美媛馆_Flower朱可儿《魅惑极致的黑丝内衣》-Vol.391-写真集-40P-
美媛馆_K8傲娇萌萌Vivian《泳池比基尼-性感睡衣系列》-Vol.265-写真集-36P-
美媛馆_Kitty星辰-沈佳熹----美胸尤物-Vol.034-写真集-54P-
美媛馆_Love陆瓷《沙滩系列-兔女郎-圣诞系列》-Vol.089-写真集-55P-
美媛馆_Love陆瓷《蕾丝睡衣-丁字裤》-Vol.082-写真集-28P-
美媛馆_luna张静燕《白色清透内衣》-Vol.406-写真集-42P-
美媛馆_luna张静燕《粉色的蕾丝睡衣》-Vol.399-写真集-44P-
美媛馆_Manuela玛鲁娜《大理旅拍》室内-室外-Vol.111-写真集-72P-
美媛馆_Manuela玛鲁娜《学生装制服》-Vol.107-写真集-50P-
美媛馆_MARA酱《三亚旅拍》比基尼-内衣-浴室湿身-Vol.047-写真集-49P-
美媛馆_MARA醬《三亚旅拍活动》-Vol.011-写真集-51P-
美媛馆_MARA醬《民族风-女警COS-私房》-Vol.071-写真集-48P-
美媛馆_MARA醬《泰国旅拍Pai县》热裤妹子-蕾丝泳装-Vol.097-写真集-60P-
美媛馆_MARA醬《泰国旅拍》性感内衣-短裙街拍-Vol.085-写真集-50P-
美媛馆_MARA醬《泰国清迈旅拍》牛仔热裤-唯美薄纱-Vol.094-写真集-56P-
美媛馆_MARA醬-王馨瑶yanni-刘雪妮Verna-子纯儿Annie-妮儿Bluelabel《丽江旅拍合集预告》-Vol.066-写真集-45P-
美媛馆_MARA醬《透视薄纱-唯美长裙》-Vol.101-写真集-42P-
美媛馆_Milk楚楚《2套超短裙-内衣诱惑》-Vol.139-写真集-60P-
美媛馆_Milk楚楚《海滩死库水》-Vol.147-写真集-64P-
美媛馆_Milk楚楚《私房内衣诱惑》-Vol.142-写真集-68P-
美媛馆_Milk楚楚《超清新短裙女神》-Vol.154-写真集-41P-
美媛馆_Milk楚楚《龙目岛旅拍》外拍4套内衣-Vol.160-写真集-64P-
美媛馆_Milk楚楚《龙目岛旅拍》清凉比基尼-Vol.151-写真集-57P-
美媛馆_moa小姐《日本和服主题》-Vol.136-写真集-61P-
美媛馆_Moa小姐《来自四川成都的新人模特》-Vol.132-写真集-30P-
美媛馆_nova李雅《变化的诱人内衣》-Vol.410-写真集-57P-
美媛馆_SOLO_尹菲《一场连绵缠绵的的诱惑》-Vol.343-写真集-44P-
美媛馆_SOLO-尹菲《十足的浴室湿身系列》-Vol.327-写真集-26P-
美媛馆_SOLO-尹菲《大胆户外美臀拍摄系列》-Vol.348-写真集-54P-
美媛馆_SOLO-尹菲《开背毛衣系列》-Vol.335-写真集-52P-
美媛馆_SOLO_尹菲《户外拍摄的学生制服系列》-Vol.341-写真集-44P-
美媛馆_SOLO_尹菲《日本旅拍浴池湿身》-Vol.345-写真集-43P-
美媛馆_toro羽住《三亚旅拍合集》-Vol.012-写真集-118P-
美媛馆_toro羽住《小清新邻家女孩》-Vol.086-写真集-44P-
美媛馆_vetiver嘉宝贝儿《2套比基尼》-Vol.217-写真集-47P-
美媛馆_vetiver嘉宝贝儿《一套内衣-一套宠物小精灵比基尼》-Vol.220-写真集-57P-
美媛馆_vetiver嘉宝贝儿《三亚旅拍》比基尼-热裤-Vol.227-写真集-77P-
美媛馆_vetiver嘉宝贝儿《五月三亚旅拍-合集完整高清版！》-Vol.007-写真集-129P-
美媛馆_Vetiver嘉宝贝儿《厦门旅拍》清新长裙-内衣-比基尼-Vol.074-写真集-75P-
美媛馆_vetiver嘉宝贝儿《大理旅拍》车震篇-Vol.110-写真集-47P-
美媛馆_Vetiver嘉宝贝儿《小清新唯美长裙-牛仔装》-Vol.106-写真集-50P-
美媛馆_vetiver嘉宝贝儿《性感睡衣-黑丝翘臀系列》-Vol.081-写真集-32P-
美媛馆_vetiver嘉宝贝儿《死库水-泳装-长裙》-Vol.231-写真集-49P-
美媛馆_vetiver嘉宝贝儿《泰国旅拍》长裙-睡衣-内衣-Vol.087-写真集-67P-
美媛馆_vetiver嘉宝贝儿《美而不妖，艳而不俗，千娇百媚，无与伦比》-Vol.234-写真集-59P-
美媛馆_-Vol.193-《前凸后翘身材火辣辣的妹子》写真集-33P-
美媛馆_-Vol.432-糯美子Mini-《魅惑镂空内衣-开档黑丝》-写真集-77P-
美媛馆_-Vol.433-张雨萌-《超短牛仔裤系列》-写真集-31P-
美媛馆_-Vol.434-任莹樱-《凹凸别致巨乳身材》-写真集-50P-
美媛馆_-Vol.435-方子萱-《运动服饰之下超性感的身材》-写真集-54P-
美媛馆_-Vol.436-小宣fancy---秘书眼镜OL写真-68P-
美媛馆_-Vol.437-久久Aimee-《白衬衫黑丝袜系列》-写真集-45P-
美媛馆_-Vol.438-方子萱-《居家女友的视觉体验》-写真集-65P-
美媛馆_-Vol.439-Laura张小妮-《经典的JK制服》-写真集-57P-
美媛馆_-Vol.440-言沫-《黑色性感筒袜装系列》-写真集-36P-
美媛馆_-Vol.441-方子萱-《黑丝美腿》-写真集-59P-
美媛馆_-Vol.442-久久Aimee-《青春JK制服系列》-写真集-37P-
美媛馆_-Vol.443-言沫-《美腿翘臀十足诱人》-写真集-34P-
美媛馆_-Vol.444-方子萱---性感皮裙与极致黑丝-104P-
美媛馆_-Vol.445-薛琪琪sandy---牛仔裤美臀系列-57P-
美媛馆_-Vol.446-方子萱---古典韵味旗袍与现代丝袜-105P-
美媛馆_-Vol.447-方子萱---典雅长裙勾勒的曲线曼妙多姿-92P-
美媛馆_-Vol.448-方子萱---干练率性的职业西装-76P-
美媛馆_-Vol.449-方子萱---性感比基尼系列-70P-
美媛馆_-Vol.450-方子萱--运动内衣主题系列-83P-
美媛馆_-Vol.451-陈舒羽---米色连衣裙-黑丝美腿-66P-
美媛馆_-Vol.452-陈一涵---职场秘书制服与鲜红睡衣系列-83P-
美媛馆_-Vol.453-小波多---性感连体衣写真-62P-
美媛馆_-Vol.454-唐琪儿---性感内衣系列-40P-
美媛馆_-Vol.455-唐琪儿---蕾丝内衣的性感与典雅礼裙-61P-
美媛馆_-Vol.456-monika九月---运动内衣之下的魔鬼般惹火身材-41P-
美媛馆_-Vol.457-唐琪儿---黑色吊裙丝袜主题-113P-
美媛馆_-Vol.458-唐琪儿---OL写真-70P-
美媛馆_-Vol.459-唐琪儿---修身牛仔裤勾勒的秀腿美臀-72P-
美媛馆_-Vol.460-糯美子MINlbabe---古典韵味的粉色旗袍-76P-
美媛馆_-Vol.461-唐琪儿---经典的蕾丝内衣主题系列-138P-
美媛馆_-Vol.462-小海臀Rena---率性白衬衫与魅惑皮裙系列-54P-
美媛馆_-Vol.463-唐琪儿---日系泳装写真-75P-
美媛馆_-Vol.464-唐琪儿---抹胸礼裙与极致魅惑黑丝-66P-
美媛馆_-Vol.465-软软子---味旗袍与现代魅惑黑丝-52P-
美媛馆_-Vol.466-唐琪儿---猩红大衣-蕾丝吊袜内衣-45P-
美媛馆_-Vol.467-绮里嘉ula---连衣内衣与朦胧丝袜-40P-
美媛馆_-Vol.468-绮里嘉ula---古典旗袍-性感肉丝-40P-
美媛馆_-Vol.469-绮里嘉ula---想拥有这样一位女秘书-73P-
美媛馆_-Vol.470-绮里嘉ula---牛仔裤与白色毛衣-82P-
美媛馆_-Vol.471-绮里嘉ula---圣诞主题写真-74P-
美媛馆_-Vol.472-绮里嘉ula---皮衣-浴室淋漓湿身系列-61P-
美媛馆_-Vol.473-唐琪儿---浓情古典婀娜旗袍着身-148P-
美媛馆_Yuli黄佳丽《白衬衫-内衣诱惑》-Vol.196-写真集-21P-
美媛馆_丁筱南《大尺度私房系列》-Vol.194-写真集-17P-
美媛馆_三亚旅拍合集预告篇-Vol.036-写真集-54P-
美媛馆_于大乔《一如出水的洛神》-Vol.268-写真集-51P-
美媛馆_于大乔《沙滩比基尼》-Vol.263-写真集-58P-
美媛馆_于大乔-美瑜《普吉岛旅拍》第2套-Vol.284-写真集-53P-
美媛馆_于大小姐AYU《6套性感小睡衣》-Vol.061-写真集-54P-
美媛馆_于大小姐ayu《多套性感小睡衣》-Vol.059-写真集-59P-
美媛馆_于大小姐AYU《小睡衣系列第五套》-Vol.067-写真集-54P-
美媛馆_于大小姐AYU《性感小睡衣》第3套-Vol.063-写真集-51P-
美媛馆_于大小姐AYU《深圳拍摄的于大服装片》-Vol.050-写真集-68P-
美媛馆_于大小姐AYU《第4套-性感小睡衣系列》-Vol.065-写真集-49P-
美媛馆_于大小姐AYU《街拍超短裙-可爱内衣》-Vol.018-写真集-58P-
美媛馆_于小小姐Momo《96年的于小妹》-Vol.119-写真集-45P-
美媛馆_仓井优香《大胆内衣私房》-Vol.351-写真集-47P-
美媛馆_仓井优香《性感私房吊带系列》-Vol.359-写真集-67P-
美媛馆_仓井优香《浴池内衣湿身系列》-Vol.362-写真集-36P-
美媛馆_仓井优香《清甜乖巧的小兔子》-Vol.349-写真集-38P-
美媛馆_任莹樱《丰胸巨乳的凹凸别致身材》-Vol.372-写真集-58P-
美媛馆_伊小七MoMo《三亚旅拍》室内-室外系列--Vol.174-写真集-38P-
美媛馆_佘贝拉bella《三亚旅拍》泳装-透视-内衣-Vol.164-写真集-72P-
美媛馆_佘贝拉bella《九寨沟旅拍》2套泳装诱惑-Vol.126-写真集-50P-
美媛馆_佘贝拉bella《九寨沟旅拍》内衣-透视-浴巾篇-Vol.133-写真集-50P-
美媛馆_佘贝拉bella《兔女郎、死库水、性感私房》-Vol.156-写真集-48P-
美媛馆_佘贝拉bella《龙目岛旅拍》泳装妹子外拍-Vol.149-写真集-65P-
美媛馆_八宝icey、Fiona伊雨蔓《合集》-Vol.092-写真集-41P-
美媛馆_八宝icey《厦门旅拍》泳装-制服-Vol.075-写真集-66P-
美媛馆_八宝icey《外拍内衣-湿身》-Vol.022-写真集-65P-
美媛馆_养眼新人女神-艾然Airan-Vol.241-写真集-51P-
美媛馆_冯木木LRIS《-依旧性感-帅气十足》-Vol.219-写真集-40P-
美媛馆_冯木木LRIS《帅气的短发妹子》-Vol.204-写真集-55P-
美媛馆_冯木木LRIS《浴室性感私房》-Vol.222-写真集-29P-
美媛馆_刘娅希《室拍2套爆乳泳装》-Vol.122-写真集-66P-
美媛馆_刘娅希《浴室系列》-Vol.172-写真集-46P-
美媛馆_刘娅希《长沙写真》2套内衣-Vol.134-写真集-66P-
美媛馆_刘娅希《长沙写真》热裤-泳装-Vol.123-写真集-62P-
美媛馆_刘娅希《黑色兔女郎》-Vol.145-写真集-55P-
美媛馆_刘雪妮Verna《三亚旅拍》比基尼-透视内衣-Vol.045-写真集-55P-
美媛馆_刘雪妮Verna《丽江旅拍》情趣旗袍-内衣-超短裙-Vol.069-写真集-55P-
美媛馆_刘雪妮Verna《大理旅拍》内衣-英伦校服-Vol.108-写真集-41P-
美媛馆_刘雪妮Verna《泰国旅拍第2辑》-Vol.027-写真集-33P-
美媛馆_刘雪妮Verna《泰国旅拍第一套》-Vol.019-写真集-50P-
美媛馆_刘雪妮Verna《泰国旅拍》蕾丝睡衣-比基尼-街拍-Vol.088-写真集-47P-
美媛馆_刘飞儿Faye《厦门旅拍》爆乳美胸-清新蕾丝-Vol.078-写真集-50P-
美媛馆_刘飞儿Faye《夏门旅拍》性感睡衣系列-Vol.076-写真集-36P-
美媛馆_刘飞儿Faye《大理旅拍》2套爆乳泳装-Vol.112-写真集-73P-
美媛馆_刘飞儿Faye《大理旅拍》爆乳牛仔妹子的诱惑-Vol.104-写真集-63P-
美媛馆_刘飞儿Faye《大理旅拍》爆乳阳光少女篇-Vol.115-写真集-59P-
美媛馆_南湘baby《2套性感泳装》-Vol.048-写真集-38P-
美媛馆_南湘baby-Vol.003-写真集-57P-
美媛馆_南湘baby《翘臀丁字裤尤物》-Vol.020-写真集-55P-
美媛馆_叶籽亿-Vol.006-写真集-88P-
美媛馆_叶籽亿《三亚旅拍活动》-Vol.009-写真集-50P-
美媛馆_唐琪儿Beauty《嗜血尺度的诱惑》-VOL.246-写真集-42P-
美媛馆_唐琪儿Beauty《性感蕾丝厨娘》-VOL.236-写真集-14P-
美媛馆_唐琪儿Beauty《红色蕾丝内衣系列》-VOL.237-写真集-27P-
美媛馆_唐琪儿il《三点式性感内衣-性感睡衣》-VOL.250-写真集-46P-
美媛馆_唐琪儿il《外拍韵味旗袍系列》-Vol.300-写真集-46P-
美媛馆_唐琪儿il《大尺度福利合集》-Vol.282-写真集-90P-
美媛馆_唐琪儿il《开背毛衣-海滩湿身》-Vol.287-写真集-80P-
美媛馆_唐琪儿il《心愿旅拍写真预告》-VOL.254-写真集-58P-
美媛馆_唐琪儿il《最后一套绝版写真》-Vol.306-写真集-41P-
美媛馆_唐琪儿il《比基尼-湿身系列精彩诱惑》-VOL.273-写真集-86P-
美媛馆_唐琪儿il《波西米亚风的小清新》-Vol.264-写真集-51P-
美媛馆_唐琪儿il《浴室主题珍藏版》-Vol.278-写真集-44P-
美媛馆_唐琪儿il《海边白衬衫-短裙系列》-VOL.259-写真集-60P-
美媛馆_唐琪儿il《猫耳-吊带睡裙系列》-VOL.256-写真集-62P-
美媛馆_唐琪儿il《迟来的元旦礼物》-Vol.274-写真集-49P-
美媛馆_唐琪儿il《透视内衣与衬衫湿身演绎精彩诱惑》-Vol.277-写真集-66P-
美媛馆_唐琪儿il《透视蕾丝内衣与泳衣湿身》-VOL.258-写真集-49P-
美媛馆_唐琪儿il《高叉蕾丝长裙的魅惑》-VOL.248-写真集-51P-
美媛馆_唐琪儿il《黑色短裙极致美臀诱惑》-VOL.270-写真集-50P-
美媛馆_夏小秋秋秋《九寨沟旅拍》室内私房-Vol.129-写真集-53P-
美媛馆_夏小秋秋秋《牛仔拍-蕾丝旗袍》-Vol.125-写真集-68P-
美媛馆_夏瑶baby《九寨沟旅拍》2套性感内衣-Vol.124-写真集-59P-
美媛馆_夏瑶baby《爆乳妹子私拍》-Vol.118-写真集-42P-
美媛馆_夏瑶baby《爆乳比基尼-内衣诱惑》-Vol.120-写真集-26P-
美媛馆_夏茉GIGI《2套性感服饰》-Vol.141-写真集-50P-
美媛馆_夏茉GIGI《内衣、丁字裤诱惑》-Vol.137-写真集-49P-
美媛馆_夏茉GIGI《蕾丝内衣-浴巾私房》-Vol.144-写真集-37P-
美媛馆_大奶飞-刘飞儿Faye《户外牛奶篇-室内性感皮裤篇！》-Vol.109-写真集-65P-
美媛馆_奈美nana《古典韵味肚兜与情趣丁字裤系列》-Vol.377-写真集-43P-
美媛馆_奈美nana《身体高挑多姿且凹凸别致的美女》-Vol.369-写真集-52P-
美媛馆_奈美nana《身体高挑多姿且凹凸别致的美女》-Vol.375-写真集-63P-
美媛馆_女神-于大乔复出-Vol.260-写真集-48P-
美媛馆_女神-晓茜sunny《胸器少女》-Vol.276-写真集-65P-
美媛馆_女神-栗子Riz《旗袍内衣》-Vol.332-写真集-41P-
美媛馆_女神-绮里嘉ula复出-Vol.261-写真集-50P-
美媛馆_妮儿Bluelabel《外拍2套清新内衣》-Vol.070-写真集-51P-
美媛馆_妮儿Bluelabel《性感内衣-比基尼》-Vol.021-写真集-60P-
美媛馆_子纯儿Annie《外拍内衣-比基尼》-Vol.055-写真集-48P-
美媛馆_子纯儿Annie《性感内衣-清新小旗袍》-Vol.073-写真集-50P-
美媛馆_子纯儿Annie《性感萝莉妹子》-Vol.043-写真集-47P-
美媛馆_小丽er《蜂腰翘臀极致诱惑》-VOL.244-写真集-43P-
美媛馆_小尤奈《巨乳福利》-Vol.331-写真集-34P-
美媛馆_小尤奈《清新的低胸内衣与比基尼》-Vol.342-写真集-36P-
美媛馆_小尤奈《清新的毛衣与低开束胸装》-Vol.338-写真集-48P-
美媛馆_小樱baby《身材很不错的娇滴滴妹子》-Vol.405-写真集-37P-
美媛馆_小魔女奈奈《身材娇美的纯天然妹子》-VOL.242-写真集-40P-
美媛馆_崔乖艺《成都巨乳新人妹子》-Vol.230-写真集-54P-
美媛馆_巨乳模特-温心怡《身材异常火辣》-Vol.288-写真集-49P-
美媛馆_张恬恬《浑圆美臀诱惑》-Vol.328-写真集-42P-
美媛馆_张雨萌《一位身材与颜值兼具的新晋模特》-Vol.323-写真集-61P-
美媛馆_张雨萌《凹凸别致的惹火身材》-Vol.344-写真集-38P-
美媛馆_张雨萌《精彩极致的人体诱惑》-Vol.329-写真集-39P-
美媛馆_徐cake《POLICE制服诱惑》-Vol.171-写真集-50P-
美媛馆_徐cake《性感比基尼-湿身》-Vol.168-写真集-61P-
美媛馆_徐cake《白色婚纱系列》-Vol.165-写真集-50P-
美媛馆_徐小宝Jessie《96年的写真女神新生》-Vol.116-写真集-40P-
美媛馆_徐小宝Jessie《大尺度私房篇》-Vol.117-写真集-32P-
美媛馆_徐微微mia《丰满巨乳-圆润美臀湿身诱惑》-Vol.318-写真集-40P-
美媛馆_徐微微mia《丰胸美臀诱惑》-Vol.307-写真集-79P-
美媛馆_徐微微mia《努力的写真女神》-Vol.310-写真集-41P-
美媛馆_徐微微mia《周末福利特辑》-Vol.316-写真集-55P-
美媛馆_徐微微mia《巨乳福利》-Vol.299-写真集-52P-
美媛馆_徐微微mia《性感私房诱惑》-Vol.301-写真集-38P-
美媛馆_徐微微mia《性感镂空内衣系列》-Vol.303-写真集-45P-
美媛馆_徐微微mia《猫耳女仆制服-浴室湿身诱惑》-Vol.313-写真集-41P-
美媛馆_徐微微mia《绝对吸睛的私房魅惑》-Vol.325-写真集-74P-
美媛馆_徐微微mia《诱人湿身诱惑》-Vol.340-写真集-40P-
美媛馆_徐微微mia《颜值与身材兼具的美女》-Vol.294-写真集-42P-
美媛馆_徐微微mia《香车美人诱人车拍》-Vol.346-写真集-54P-
美媛馆_御姐女神-于大乔《人间仙女》-Vol.281-写真集-76P-
美媛馆_《性感十足，胸器逼人的模特》合集-Vol.211-写真集-30P-
美媛馆_性感女神-Flower朱可儿《精彩合集套图（下部）》-Vol.385-写真集-69P-
美媛馆_悠悠酱yoyoyo《丰胸肥臀十足诱人》-Vol.426-写真集-39P-
美媛馆_悠悠酱yoyoyo《性感的内衣与诱人浴袍系列》-No.415-写真集-34P-
美媛馆_悠悠酱yoyoyo《诱人蕾丝内衣私房魅惑》-Vol.429-写真集-49P-
美媛馆_文艺妹子-八宝icey《三亚旅拍》-Vol.046-写真集-53P-
美媛馆_新人模特-小珂luka-VOL.247-写真集-56P-
美媛馆_晓茜sunny《性感吊带小背心-粉色内衣》-VOL.253-写真集-61P-
美媛馆_晓茜sunny《性感高叉-白色爆乳内衣》-VOL.257-写真集-46P-
美媛馆_晓茜sunny《无内裤牛仔内衣-性感比基尼》-Vol.262-写真集-74P-
美媛馆_晓茜sunny《极致丰胸美乳诱惑》-VOL.271写真集-65P-
美媛馆_晓茜sunny《海边沙滩系列》-Vol.308-写真集-44P-
美媛馆_晓茜sunny《海边波点式比基尼系列》-Vol.267-写真集-76P-
美媛馆_晓茜sunny《海边诱人的魅力》-Vol.283-写真集-50P-
美媛馆_朱可儿Flower《室外草次镂空吊裙系列》-Vol.423-写真集-40P-
美媛馆_朱可儿Flower《性感血滴子内衣系列》-Vol.419-写真集-40P-
美媛馆_朱可儿Flower《户外草地拍摄系列》-Vol.416-写真集-83P-
美媛馆_李可可《性感外拍私房魅惑》-Vol.317-写真集-43P-
美媛馆_李可可《性感尺度福利》-Vol.305-写真集-35P-
美媛馆_李可可《性感蕾丝》-Vol.280-写真集-35P-
美媛馆_李可可《性感蕾丝网袜的诱惑》-Vol.290-写真集-40P-
美媛馆_李可可《性感黑丝诱惑》-Vol.296-写真集-40P-
美媛馆_李可可《日本旅拍特辑》-Vol.333-写真集-48P-
美媛馆_李可可《湿身诱惑》-Vol.315-写真集-44P-
美媛馆_李可可《难以抗拒的诱惑》-Vol.286-写真集-56P-
美媛馆_李李七七喜喜《性感女神》-Vol.285-写真集-80P-
美媛馆_李李七七喜喜《衬衫、蕾丝以及变化的撩人姿势》-Vol.319-写真集-59P-
美媛馆_李雪婷Anna《5套性感服饰》-Vol.135-写真集-51P-
美媛馆_李雪婷Anna《初登场》蕾丝、透视内衣-Vol.127-写真集-53P-
美媛馆_李雪婷Anna《外拍爆乳比基尼》-Vol.181-写真集-60P-
美媛馆_李雪婷Anna《苏梅岛旅拍》泳装-内衣-Vol.177-写真集-70P-
美媛馆_杨晓青儿《丁字裤翘臀-街拍系列》-Vol.102-写真集-55P-
美媛馆_杨晓青儿《极品清新短裙-内衣外拍》-Vol.093-写真集-82P-
美媛馆_杨晓青儿《比基尼-校服外拍》-Vol.096-写真集-88P-
美媛馆_杨晓青儿《泰国Pai县》校服-热裤-内衣-Vol.099-写真集-61P-
美媛馆_杨洁linda《天生妩媚气质美女》-VOL.252-写真集-34P-
美媛馆_果儿Victoria《圣诞主题装扮-》-Vol.185-写真集-30P-
美媛馆_果儿Victoria《精彩十足的镂空内衣系列》-Vol.352-写真集-39P-
美媛馆_果儿Victoria《诱人激凸与美胸系列》-Vol.353-写真集-56P-
美媛馆_果儿Victoria《阳光下的土豪金果儿》-Vol.183-写真集-15P-
美媛馆_果儿Victoria《黄金比基尼》-Vol.188-写真集-38P-
美媛馆_栗子Riz《美臀秀腿视觉盛宴》-Vol.339-写真集-39P-
美媛馆_栗子Riz《霸道总裁爱上热辣小秘》-Vol.347-写真集-39P-
美媛馆_模特-丽俊girl-VOL.245-写真集-34P-
美媛馆_模特小妮《内衣-学生制服》-Vol.121-写真集-22P-
美媛馆_洛千栀baby《来自长沙97年的妹子》-VOL.238-写真集-44P-
美媛馆_温心怡《高颠颠，肉颤颤，粉嫩嫩，水灵灵，夺男人魂魄》-Vol.330-写真集-40P-
美媛馆_潘娇娇-《三亚旅拍》大胆唯美艺术-Vol.049-写真集-40P-
美媛馆_潘娇娇《大尺度睡衣诱惑》-Vol.032-写真集-35P-
美媛馆_潘娇娇《海南旅拍合集》-Vol.030-写真集-96P-
美媛馆_熊吖BOBO《2套性感内衣》-Vol.140-写真集-61P-
美媛馆_熊吖BOBO《三亚旅拍》内衣-比基尼-Vol.169-写真集-66P-
美媛馆_熊吖BOBO《三亚旅拍》泳装-猫耳-Vol.167-写真集-60P-
美媛馆_熊吖BOBO《双马尾妹子》-Vol.155-写真集-68P-
美媛馆_熊吖BOBO《性感睡衣》-Vol.176-写真集-64P-
美媛馆_熊吖BOBO《杭州新人女神》-Vol.143-写真集-78P-
美媛馆_熊吖BOBO《杭州行》性感内衣-浴巾系列-Vol.146-写真集-51P-
美媛馆_熊吖BOBO《死库水》-Vol.187-写真集-55P-
美媛馆_熊吖BOBO《海滩牛仔热裤-比基尼》-Vol.158-写真集-62P-
美媛馆_熊吖BOBO《老师制服诱惑》-Vol.161-写真集-40P-
美媛馆_熊吖BOBO《苏梅岛旅拍》小清新泳装-Vol.179-写真集-52P-
美媛馆_熊吖BOBO《英伦女仆装》-Vol.159-写真集-51P-
美媛馆_熊吖BOBO《蓝色竖条纹内衣系列》-Vol.182-写真集-55P-
美媛馆_熊吖BOBO《黑色性感内衣私房》-Vol.162-写真集-55P-
美媛馆_熊吖BOBO《龙目岛旅拍》外拍比基尼-Vol.152-写真集-39P-
美媛馆_熊吖BOBO《龙目岛旅拍》室拍2套内衣-Vol.192-写真集-50P-
美媛馆_熊吖BOBO《龙目岛旅拍》海滩唯美清新系列-Vol.191-写真集-67P-
美媛馆_熊吖BOBO《龙目岛旅拍》牛仔女神-黑丝内衣-Vol.148-写真集-64P-
美媛馆_狐小妖Baby《无可比拟的美臀诱惑力》-Vol.321-写真集-51P-
美媛馆_狐小妖Baby《无可比拟的美臀诱惑力》-Vol.336-写真集-35P-
美媛馆_猩一《多套性感服装！！》-VOL.243-写真集-39P-
美媛馆_猩一《来自重庆的尤物》-Vol.178-写真集-20P-
美媛馆_猫本amy《澳大利亚墨尔本归来的美妞--》-Vol.130-写真集-30P-
美媛馆_王雨纯《丰胸肥臀的私房魅惑》-Vol.309-写真集-41P-
美媛馆_王雨纯《大尺度白嫩尤物》-Vol.206-写真集-27P-
美媛馆_王雨纯《如此出众的警花王雨纯》-Vol.320-写真集-45P-
美媛馆_王雨纯《方块内衣的诱惑》-Vol.210-写真集-38P-
美媛馆_王雨纯《车内诱惑-死库水》-Vol.214-写真集-49P-
美媛馆_王雨纯《黑丝网袜翘臀系列》-Vol.208-写真集-47P-
美媛馆_王馨瑶yanni-Vol.001-写真集-102P-
美媛馆_王馨瑶yanni《万种风情-主打旗袍系列》-Vol.080-写真集-56P-
美媛馆_王馨瑶yanni《三亚旅拍合集！》-Vol.008-写真集-156P-
美媛馆_王馨瑶yanni《三月份三亚拍摄的第4集》-Vol.051-写真集-75P-
美媛馆_王馨瑶yanni《丽江旅拍》睡衣-2套内衣-Vol.068-写真集-75P-
美媛馆_王馨瑶yanni《丽江旅拍》超清新唯美外拍篇-Vol.079-写真集-57P-
美媛馆_王馨瑶yanni《大理旅拍》格子衬衫-比基尼-Vol.113-写真集-61P-
美媛馆_王馨瑶yanni《小清新系列》-Vol.293-写真集-40P-
美媛馆_王馨瑶yanni《泰国旅拍全集》-Vol.017-写真集-122P-
美媛馆_王馨瑶yanni《泰国清迈旅拍》清新超短裙系列-Vol.098-写真集-73P-
美媛馆_王馨瑶yanni《泰国清迈旅拍》街拍-浴袍-皮卡丘-Vol.095-写真集-60P-
美媛馆_王馨瑶yanni《程旅游专辑》-Vol.038-写真集-72P-
美媛馆_王馨瑶yanni《草帽少女-OL美人》-Vol.312-写真集-47P-
美媛馆_王馨瑶yanni《街拍极品校服少女》-Vol.103-写真集-60P-
美媛馆_玛鲁娜Manuela《美臀秀》-Vol.114-写真集-61P-
美媛馆_瑞莎Trista《H-CUP！！》-Vol.128-写真集-51P-
美媛馆_瑞莎Trista《超巨乳》-Vol.138-写真集-31P-
美媛馆_田孝媛《护士装主题》-Vol.200-写真集-15P-
美媛馆_田孝媛《蕾丝内衣-护士装》-Vol.198-写真集-16P-
美媛馆_田芯娜Angel《性感美臀，精致长相，完美身材S曲线》-Vol.190-写真集-45P-
美媛馆_童丹娜cara《妹子COS系列》-Vol.354-写真集-48P-
美媛馆_童丹娜cara《情趣网袜与狂野豹纹系列》-Vol.358-写真集-65P-
美媛馆_粉芭比VV《像芭比娃娃的新人妹子》-Vol.209-写真集-44P-
美媛馆_粉芭比VV《真人版芭比娃娃的性感魅惑》-Vol.225-写真集-52P-
美媛馆_糯美子Mini《三点式内衣》-Vol.402-写真集-50P-
美媛馆_糯美子Mini《三点式比基尼下美胸呼之欲出》-Vol.371-写真集-70P-
美媛馆_糯美子Mini《呼之欲出的雪峰与肥臀》-Vol.398-写真集-50P-
美媛馆_糯美子Mini《呼之欲出的雪峰与肥臀》-Vol.414-写真集-59P-
美媛馆_糯美子Mini《居家女仆主题》-Vol.381-写真集-100P-
美媛馆_糯美子Mini《异域风情的内衣系列诱惑》-Vol.379-写真集-100P-
美媛馆_糯美子Mini《性感内衣下凹凸有致身材》-Vol.395-写真集-55P-
美媛馆_糯美子Mini《性感牛仔系列》-Vol.431-写真集写真集-62P-
美媛馆_糯美子Mini《性感的精致镂空内衣》-Vol.407-写真集-72P-
美媛馆_糯美子Mini《性感粉色内衣》-Vol.417-写真集-65P-
美媛馆_糯美子Mini《日本旅拍私人定制》-Vol.390-写真集-87P-
美媛馆_糯美子Mini《日系私房主题系列》-Vol.422-写真集-48P-
美媛馆_糯美子Mini《清纯不失性感力》-Vol.430-写真集-112P-
美媛馆_糯美子Mini《礼物的丝带极致诱惑》-Vol.396-写真集-84P-
美媛馆_糯美子Mini《私房牛仔裤系列》-Vol.428-写真集-115P-
美媛馆_糯美子Mini《童颜巨乳的身材》-Vol.418-写真集-80P-
美媛馆_糯美子Mini《童颜巨乳蕾丝妹子》-Vol.376-写真集-59P-
美媛馆_糯美子Mini《粉嫩内衣-粉油系列》-Vol.425-写真集-70P-
美媛馆_糯美子Mini《粉色清透的内衣》-Vol.378-写真集-53P-
美媛馆_糯美子Mini《粉色的吊带与透空的内衣系列》-Vol.413-写真集-75P-
美媛馆_糯美子Mini《粉色的情趣内衣》-Vol.424-写真集-59P-
美媛馆_糯美子Mini《精致镂空内衣-网袜诱惑》-Vol.421-写真集-72P-
美媛馆_糯美子Mini《透明镂空的薄纱内衣系列》-Vol.411-写真集-56P-
美媛馆_糯美子Mini《酒店秘书制服》-Vol.427-写真集-58P-
美媛馆_糯美子Mini《颜值清甜靓丽肌肤雪白细腻》-Vol.374-写真集-61P-
美媛馆_糯美子Mini《魅惑的镂空蕾丝内衣系列》-Vol.386-写真集-100P-
美媛馆_糯美子Mini《魅惑黑色的清透内衣系列》-Vol.404-写真集-46P-
美媛馆_绮里ula《多套服装的合集》-Vol.266-写真集-66P-
美媛馆_绮里ula《阳光-沙滩-厨房》-VOL.272-写真集-59P-
美媛馆_绮里嘉ula《三亚旅拍》2套性感内衣-Vol.037-写真集-50P-
美媛馆_绮里嘉ula《三亚旅拍》2套比基尼-长裙-Vol.057-写真集-56P-
美媛馆_绮里嘉ula《三亚旅拍》2套透视内衣篇-Vol.052-写真集-57P-
美媛馆_绮里嘉ula《三亚旅拍》最后一套合集-Vol.062-写真集-68P-
美媛馆_绮里嘉ula《同程旅游专辑》-Vol.042-写真集-67P-
美媛馆_绮里嘉ula《大尺度浴室系列》-Vol.029-写真集-24P-
美媛馆_绮里嘉ula《大胆湿身-比基尼》-Vol.060-写真集-46P-
美媛馆_绮里嘉ula《惹火内衣与情趣链条系列》-Vol.380-写真集-80P-
美媛馆_绮里嘉ula《泰国写真合集一》-Vol.014-写真集-119P-
美媛馆_绮里嘉ula《泰国旅拍合集二》-Vol.015-写真集-118P-
美媛馆_绮里嘉ula《泰国旅拍》曼谷sofitel酒店篇-Vol.084-写真集-51P-
美媛馆_绮里嘉ula《泰国旅拍》英伦风校服-短裙-比基尼-Vol.091-写真集-54P-
美媛馆_绮里嘉ula《精致蕾丝睡衣与筒袜诱惑》-Vol.420-写真集-40P-
美媛馆_绮里嘉ula《蕾丝镂空内衣的精妙与筒袜诱惑》-Vol.401-写真集-40P-
美媛馆_绿茶女神-王馨瑶yanni《高叉内衣-护士服》-Vol.105-写真集-61P-
美媛馆_网红尤物-潘娇娇-Vol.031-写真集-35P-
美媛馆_美宝merry《3套私房内衣》-Vol.028-写真集-40P-
美媛馆_美瑜《御姐女神》-Vol.295-写真集-54P-
美媛馆_美胸翘臀模特-李雪婷Anna-Vol.189-写真集-52P-
美媛馆_羽住real《性感比基尼与温柔可儿女仆系列》-Vol.356-写真集-54P-
美媛馆_胡润曦201712《爆满的美胸与硕大肥臀》-Vol.337-写真集-30P-
美媛馆_艾然Airan-小珂luka及其他模特合集-VOL.240-写真集-27P-
美媛馆_芝芝Booty《三亚旅拍》清新妹子的诱惑-Vol.224-写真集-55P-
美媛馆_芝芝Booty《性感高叉》-Vol.218-写真集-37P-
美媛馆_芝芝Booty《校服泳装诱惑》-Vol.221-写真集-15P-
美媛馆_芝芝Booty《清纯甜美不失性感诱人》-Vol.229-写真集-32P-
美媛馆_苏可er《美胸与黑丝福利》-Vol.311-写真集-39P-
美媛馆_苏可er《美臀诱惑》-Vol.324-写真集-41P-
美媛馆_苏可er《诱惑黑丝与性感激凸》-Vol.291-写真集-52P-
美媛馆_蔡文钰Angle《两套三点式内衣》-VOL.251-写真集-58P-
美媛馆_蔡文钰Angle《可爱中不失诱惑》-Vol.213-写真集-47P-
美媛馆_蔡文钰Angle《巨乳嫩模》-Vol.215-写真集-48P-
美媛馆_蔡文钰Angle《性感红肚兜与比基尼湿身》-VOL.255-写真集-53P-
美媛馆_蔡文钰Angle《水手服学生制服》-Vol.212-写真集-44P-
美媛馆_蔡文钰Angle《火辣牛仔裤-透视蕾丝内衣》-Vol.275-写真集-58P-
美媛馆_蔡文钰Angle、王雨纯《合集》--Vol.216-写真集-55P-
美媛馆_蔡文钰Angle《衬衣、比基尼，高开日系海军服》-VOL.269-写真集-48P-
美媛馆_蔡文钰Angle《魅惑的视觉冲击力》-Vol.279-写真集-46P-
美媛馆_表妹夏瑶baby《九寨沟旅拍》主打2套泳装-Vol.131-写真集-54P-
美媛馆_许诺Sabrina《3套服饰-美得让人窒息》-Vol.233-写真集-64P-
美媛馆_许诺Sabrina《三亚旅拍》情趣美臀系列-Vol.039-写真集-47P-
美媛馆_许诺Sabrina《三亚旅拍活动》-Vol.010-写真集-116P-
美媛馆_许诺Sabrina《不知火舞COS》-Vol.235-写真集-42P-
美媛馆_许诺Sabrina《内衣丁字裤-2套裙装》-Vol.083-写真集-50P-
美媛馆_许诺Sabrina《厦门旅拍》4套性感服饰-Vol.077-写真集-61P-
美媛馆_许诺Sabrina《厦门旅拍》内衣-校服系列-Vol.072-写真集-74P-
美媛馆_许诺Sabrina《性感网袜-内衣-猫耳》-Vol.053-写真集-60P-
美媛馆_许诺Sabrina《楚楚可人、娇艳欲滴的女神》-Vol.223-写真集-53P-
美媛馆_许诺Sabrina《气质长裙与诱惑丝袜美腿》-Vol.232-写真集-61P-
美媛馆_许诺Sabrina《泰国旅拍全套》-Vol.023-写真集-58P-
美媛馆_许诺Sabrina《泰国旅拍》性感内衣-圣诞装-Vol.090-写真集-55P-
美媛馆_许诺Sabrina《浴巾-睡衣》-Vol.228-写真集-60P-
美媛馆_许诺Sabrina《虎纹内衣-透视情趣装》-Vol.058-写真集-47P-
美媛馆_赵小米Kitty《天然甜美的96年新人妹子》-Vol.195-写真集-49P-
美媛馆_赵小米Kitty《性感室拍裹胸泳装-浴巾系列》-Vol.199-写真集-33P-
美媛馆_赵小米Kitty《性感比基尼-可爱比卡丘-超短牛仔裤》-Vol.203-写真集-49P-
美媛馆_赵小米Kitty《水手服泳装》-Vol.205-写真集-53P-
美媛馆_赵小米Kitty《浴室系列-清新外拍》-Vol.201-写真集-50P-
美媛馆_赵小米Kitty《清纯热裤妹子诱惑》-Vol.197-写真集-52P-
美媛馆_赵小米Kitty《白色三点比基尼》-Vol.207-写真集-48P-
美媛馆_阿乖Kiddo《童颜巨乳大美女》-Vol.226-写真集-54P-
美媛馆_陈思雨Mango-1st-Vol.004-写真集-44P-
美媛馆_陈怡曼coco《性感丝袜福利》-Vol.297-写真集-56P-
美媛馆_黄可christine《2套睡衣-泳装》-Vol.033-写真集-61P-
美媛馆_黄密儿-Vol.002-写真集-63P-
美媛馆_黄楽然《凹凸别致娇躯诱惑》-Vol.314-写真集写真集-56P-
美媛馆_黄楽然《性感睡衣》-Vol.292-写真集-69P-
美媛馆_黄楽然《情趣血滴子》-Vol.302-写真集-61P-
美媛馆_黄楽然《极致黑丝福利》-Vol.289-写真集-55P-
EOF;


$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$dryrun = 0;
$org_name = '美媛馆';
$org_name_en = 'MyGirl';

$scan = scandir($folder_full_path);
foreach($scan as $folder_name) {
   if (is_dir("$folder_full_path/$folder_name") && $folder_name!='.' && $folder_name!='..' ) {
        $the_full_path = "$folder_full_path/$folder_name";
        echo "------------------------- \n";
        echo "-- Current folder: $folder_name \n";
        // Get cuurent folder vol number
        $l_folder_name = strtolower($folder_name);
        $l_folder_name = str_replace('vol.', 'no.', $l_folder_name);
        // $v_arr = explode(' ',$l_folder_name);
        $v_arr = find_between($l_folder_name, 'no.', ' ');
        $vol = $v_arr[0];

        // $vol = str_replace('no.', '', $vol);
        // Go to origin path to get folder name with the same vol num
        $origin = getOriginFolderByVol($vol);
        echo print_r($origin,1) . "\n"; 
        
        if(!empty($origin)) {
            // copy desc.txt and tags.txt from origin folder
            $desc_str = file_get_contents($origin['full_path'] . "/desc.txt");
            $desc_str = str_replace(' 生日','生日', $desc_str);
            $pos = strpos($desc_str, '生日');
            if($pos !== false) {
                $c = $desc_str[$pos-1];
                if ($c != "\n" && $c != "\rn" && $c != "\r") {
                    $desc_str = str_replace('生日',"\n生日", $desc_str);
                }
            }
            $desc_str = str_replace(' 罩杯','罩杯', $desc_str);
            $pos = strpos($desc_str, '罩杯');
            if($pos !== false) {
                $c = $desc_str[$pos-1];
                if ($c != "\n" && $c != "\rn" && $c != "\r") {
                    $desc_str = str_replace('罩杯',"\n罩杯", $desc_str);
                }
            }
            echo "Processing " . $the_full_path . "/desc.txt \n";
            if(!$dryrun) file_put_contents($the_full_path.'/desc.txt', $desc_str);
            
            // copy($origin['full_path'] . "/tags.txt", $the_full_path . "/tags.txt");

            // Gen new tags
            $tags_str = file_get_contents($origin['full_path'] . "/tags.txt");
            $tags = explode(',', $tags_str);
            if(! in_array($org_name_en, $tags) && ! in_array(strtolower($org_name_en), $tags)) {
                $tags[] = $org_name_en;
            }
            if(! in_array( $org_name, $tags ) ) {
                $tags[] = $org_name;
            }
            if(! in_array( $origin['model'], $tags ) ) {
                $tags[] = $origin['model'];
            }
            $new_tags_str = implode(',', $tags);
            $new_tags_str = str_replace(strtolower($org_name_en), $org_name_en, $new_tags_str);
            echo "---- New tags: $new_tags_str \n";
            // create tags.txt
            echo "file_put_contents($the_full_path/tags.txt, $new_tags_str) \n";
            if(!$dryrun) file_put_contents($the_full_path.'/tags.txt', $new_tags_str);

            // create a new empty dl.txt in current folder
            echo "file_put_contents($the_full_path/dl.txt, '') \n";
            if(!$dryrun) file_put_contents($the_full_path.'/dl.txt', '');

            // Handle thumbnail.jpg
            $scan2 = scandir($the_full_path);
            $images = [];
            $already_has_thumbnail = false;
            foreach($scan2 as $file) {
                $origin_file_full = $the_full_path . '/' . $file;
                if($file == 'cover.jpg') {
                    rename($the_full_path . '/cover.jpg' , $the_full_path . '/thumbnail.jpg');
                    $file = 'thumbnail.jpg';
                }
                if($file == 'thumbnail.jpg') $already_has_thumbnail = true;
                if ( is_file($origin_file_full) && @is_array(getimagesize($origin_file_full)) ) {
                    $images[] = $file;
                }
            }
            natsort($images);
            
            if($already_has_thumbnail) {
                echo "---- Already has a thumbnail.jpg \n\n";
            }
            else {
                // if((int)$vol < 37) {
                //   $thumb = $images[0];
                // }
                // else {
                    $thumb = $images[count($images) - 1];
                // }
                echo 'rename('. $the_full_path . '/' . $thumb . ', ' . $the_full_path . '/thumbnail.jpg' .  "\n\n";
                if(!$dryrun) rename($the_full_path . '/' . $thumb , $the_full_path . '/thumbnail.jpg');    
            }

            // rename current folder to the origin folder name
            if(!empty($origin['main'] )) {
                $x = explode(' ', $folder_name);
                $last = $x[1];
                
                $new_folder_name = $org_name_en.$org_name.'-'. $vol . '-'.$origin['model'] . '-' . $origin['main'] . '-'.$last;
                echo "rename $the_full_path to $folder_full_path/$new_folder_name\n\n";
                if(!$dryrun) rename($the_full_path, $folder_full_path . '/'.$new_folder_name);
            }
            
        }
        else {
            echo "-- Cannot find mapped folder ...\n";
        }
   }
}



function getOriginFolderByVol($vol_num) {
    global $dirs;
    
    global $org_name;
    
    // echo "vol_num = $vol_num \n"; exit;
    
    $origin_folders = '/mnt/nas/jw-photos/tujigu/' . $org_name;
    // $scan = scandir($origin_folders);
    $scan = explode("\r\n", $dirs);

    $folder_info = [];
    
    foreach($scan as $folder_name) {      
        // echo "folder: $folder_name \n";  
        if (is_dir("$origin_folders/$folder_name") && $folder_name!='.' && $folder_name!='..') {

            $l_folder_name = strtolower($folder_name);
            $l_folder_name = str_replace('vol.', 'no.', $l_folder_name);
            // echo "l_folder: $l_folder_name \n";
            
            if(strpos($l_folder_name, $vol_num) !== false) {
                $folder_info['full_path'] = $origin_folders  . '/' . $folder_name;

                $l_folder_name = sanatizeCN($l_folder_name);
                $l_folder_name = str_replace('_-','_',$l_folder_name);
                $l_folder_name = str_replace('---','-',$l_folder_name);
                $l_folder_name = str_replace('--','-',$l_folder_name);
                $folder_info['name'] = $l_folder_name;

                $l_folder_name = mapModelNames($l_folder_name);
                

                $tt = find_between($l_folder_name, $org_name.'_', '-');
                if(str_starts_with($tt[0], 'no.')) {
                    $ss = find_between($l_folder_name, '-', '-');
                    $folder_info['model'] = my_mb_ucfirst(sanatizeCN($ss[0]));
                    // Get "main"
                    // $yy = find_between($l_folder_name, '-', 'p-');
                    // $main_arr = explode('-', $yy[0]);
                    // array_pop($main_arr);
                    // $main = implode('-', $main_arr);
                    // $folder_info['main'] = $main;
                    // $folder_info['main'] = '';
                }
                else {
                    $xx = find_between($l_folder_name, $org_name.'_', '-');
                    $folder_info['model'] = my_mb_ucfirst(sanatizeCN($xx[0]));
                    //$yy = find_between($l_folder_name, $org_name.'_', '-no');
                    
                }
                $folder_info['model'] = str_replace('YUmi尤美', 'Yumi尤美', $folder_info['model']);


                if(strpos($folder_name, '《') !== false) {
                    $yy = find_between($folder_name, '《', '》');
                    $main = empty($yy[0]) ? '' : trim($yy[0], '-');
                }
                else {
                    $yy = find_between($folder_name, '---', '-');
                    $main = empty($yy[0]) ? '' : trim($yy[0], '-');
                }
                $main = empty($main) ? '' : '《' .my_mb_ucfirst(sanatizeCN($main))  . '》';
                $folder_info['main'] = $main;
                continue;
            }
        }
    }

    return $folder_info;
}
