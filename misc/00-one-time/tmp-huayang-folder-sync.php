<?php
require('../../bootstrap.inc.php');

$dirs = <<<EOF
语画界_Angela喜欢猫《古典的旗袍韵味》-Vol.024-写真集-52P-
语画界_Angela喜欢猫《古典韵味旗袍-丝袜下的芊芊美腿》-Vol.088-写真集-58P
语画界_Angela喜欢猫《性感空乘制服的的极致魅惑》-Vol.115-写真集-55P-
语画界_Angela喜欢猫《旗袍与黑丝的妩媚柔情》-Vol.034-写真集-51P-
语画界_Angela喜欢猫《浴室蕾丝内衣湿身》-Vol.083-写真集-60P-
语画界_Angela喜欢猫《浴室蕾丝湿身...》-Vol.017-写真集-67P-
语画界_Angela喜欢猫《眼镜OL黑丝短裙》-Vol.098-写真集-67P-
语画界_Angela喜欢猫《精致的低胸内衣》-Vol.074-写真集-52P-
语画界_Angela喜欢猫《精致的低胸内衣装扮与猩红吊裙》-Vol.046-写真集-50P-
语画界_Angela喜欢猫《精致的镂空内衣》-Vol.041-写真集-42P-
语画界_Angela喜欢猫《蕾丝内衣泳池湿身》-Vol.106-写真集-46P-
语画界_Angela喜欢猫《酥胸丝袜美腿》-Vol.004-写真集-59P-
语画界_Angela喜欢猫《镂空印花蕾丝下的芊芊美腿》-Vol.066-写真集-52P-
语画界_Angela喜欢猫《隐约之下的丝袜美腿玉足》-Vol.052-写真集-50P-
语画界_Angela喜欢猫《青花瓷与黑丝蕾丝》-Vol.026-写真集-72P-
语画界_Angela喜欢猫《魅惑的黑色内衣》-Vol.103-写真集-62P-
语画界_Angela小热巴《内衣私房》-Vol.244-写真集-87P-
语画界_Angela小热巴《古典韵味旗袍与魅惑丝袜》-Vol.193-写真集-57P-
语画界_Angela小热巴《性感丝袜内衣》-Vol.132-写真集-98P-
语画界_Angela小热巴《性感内衣-丝袜诱惑》-Vol.251-写真集-82P-
语画界_Angela小热巴《性感吊裙与蕾丝内衣》-Vol.141-写真集-23P-
语画界_Angela小热巴《旗袍丝袜美腿玉足》-Vol.236-写真集-82P-
语画界_Angela小热巴《曼妙多姿的魅惑》-Vol.182-写真集-68P-
语画界_Angela小热巴《极致丝袜主题系列》-Vol.161-写真集-65P-
语画界_Angela小热巴《浴池之内的诱人酥胸-芊芊美腿》-Vol.223-写真集-63P-
语画界_Angela小热巴《玫瑰金色的吊裙与丝袜诱惑》-Vol.256-写真集-99P-
语画界_Angela小热巴《白丝蕾丝-浴室衬衫湿身》-Vol.211-写真集-100P-
语画界_Angela小热巴《皮裤、丝袜，镂空内衣的性感》-Vol.229-写真集-113P-
语画界_Angela小热巴《眼镜OL蕾丝教鞭系列》-Vol.135-写真集-60P-
语画界_Angela小热巴《眼镜OL黑丝系列》-Vol.154-写真集-96P-
语画界_Angela小热巴《粉色的性感吊裙户外泳池系列》-Vol.150-写真集-66P-
语画界_Angela小热巴《精致的镂空内衣》-Vol.127-写真集-70P-
语画界_Angela小热巴《蕾丝内衣与诱人丝袜》-Vol.188-写真集-62P-
语画界_Angela小热巴《薄纱黑丝私房系列》-VOL.198-写真集-80P-
语画界_Angela小热巴《诱人姿态下芊芊美腿》-Vol.177-写真集-70P-
语画界_Angela小热巴《黑色魅惑》-Vol.167-写真集-52P-
语画界_Carry《丝足狂欢系列》-Vol.208-写真集-91P-
语画界_Carry《丝足狂欢系列》-Vol.242-写真集-101P-
语画界_Carry《丝足美腿狂欢系列》-Vol.190-写真集-110P-
语画界_Carry《古典韵味旗袍丝袜美腿》-Vol.196-写真集-84P-
语画界_Carry《古典韵味旗袍-性感丝袜》-Vol.196-写真集-84P-
语画界_carry陈良玲《性感丝袜美腿》-Vol.055-写真集-60P-
语画界_Carry《高挑身段下的丝袜美腿》-Vol.227-写真集-101P-
语画界_Cris_卓娅祺《浴室私房尤物》-Vol.019-写真集-51P-
语画界_Cris_卓娅祺《白色吊裙的温柔娇媚-黑丝内衣的魅惑诱人》-Vol.093-写真集-50P-
语画界_Cris_卓娅祺《白衬衫空姐制服》-Vol.117-写真集-54P-
语画界_Cris_卓娅祺《胸与浑圆的臀部际线》-Vol.064-写真集-52P-
语画界_Cris_卓娅祺《高耸起伏的美胸与浑圆的臀部》-Vol.043-写真集-55P-
语画界_Dreamy小乔《性感空乘制服与魅惑的黑丝》-Vol.160-写真集-60P-
语画界_Dreamy小乔《性感黑丝吊袜》-Vol.139-写真集-46P-
语画界_Dreamy小乔《粉色的情趣护士制服-蕾丝袜的角色诱惑》-Vol.191-写真集-61P-
语画界_Emily顾奈奈酱《肉丝朦胧丝袜的若隐若现》-Vol.112-写真集-62P-
语画界_Emily顾奈奈《魅惑黑丝-警花角色扮演》-Vol.149-写真集-58P-
语画界_Miki兔《丰满的翘臀-亭亭而立的美腿》-Vol.038-写真集-51P-
语画界_Miki兔《低胸事业线黑丝秀腿美胸》-Vol.045-写真集-53P-
语画界_Miki兔《白衬衫、黑丝袜的秘书OL》-Vol.002-写真集-62P-
语画界_Miki兔《真空的镂空内衣》-Vol.058-写真集-45P-
语画界_Miki兔《真空的镂空内衣诱惑》-Vol.016-写真集-51P-
语画界_Miko酱吖《圣诞女郎》-Vol.217-写真集-77P-
语画界_Miko酱吖《圣诞女郎主题2》-Vol.222-写真集-110P-
语画界_Miko酱吖《帅气的警花制服》-Vol.206-写真集-88P-
语画界_Miko酱吖《性感抹胸内衣与蕾丝吊袜》-Vol.248-写真集-82P-
语画界_Miko酱吖《性感牛仔裤与内衣主题魅惑》-Vol.235-写真集-100P-
语画界_Miko酱吖《性感牛仔裤-衬衫丝袜》-Vol.212-写真集-108P-
语画界_Miko酱吖《旗袍丝袜美腿》-Vol.200-写真集-108P-
语画界_Miko酱《性感睡衣小美女》-Vol.022-写真集-57P-
语画界_Miko酱《性感黑丝-蕾丝》-Vol.011-写真集-52P-
语画界_Miko酱《黑丝OL诱惑》-Vol.008-写真集-56P-
语画界_nova李雅《巨乳黑丝》-Vol.246-写真集-81P-
语画界_nova李雅《猩红的长裙-黑丝吊袜》-Vol.166-写真集-70P-
语画界_nova李雅《蓝色衬衫-短裙职业装丝袜美腿》-Vol.180-写真集-91P-
语画界_-Vol.257-杨晨晨sugar-《一袭猩红的镂空网袜内衣》-写真集-90P-
语画界_-Vol.258-Angela小热巴-《黑丝吊袜的OL》-写真集-84P-
语画界_-Vol.259-顾乔楠-《富含韵味的吊带》-写真集-65P-
语画界_-Vol.260-芝芝Booty-《极致丝袜下的美腿美臀》-写真集-86P-
语画界_-Vol.261-蓝夏Akasha-《性感内衣下美胸与美腿》-写真集-98P-
语画界_-Vol.262-杨晨晨sugar-《镂空透视情趣旗袍内衣》-写真集-71P-
语画界_-Vol.263-杨晨晨sugar-《极致黑丝美腿魅惑》-写真集-106P-
语画界_-Vol.264-冯木木LRIS-《极致丝袜的暗黑精灵》-写真集-99P-
语画界_-Vol.265-Carry-《黑丝美腿狂欢系列》-写真集-82P-
语画界_-Vol.266-芝芝Booty-《极致丝袜美腿-美尻》-写真集-76P-
语画界_-Vol.267-杨晨晨sugar-《古典皮草-暗黑丝袜》-写真集-76P-
语画界_-Vol.268-诗诗kiki-《极致黑丝与肉丝内衣》-写真集-91P-
语画界_-Vol.269-蓝夏Akasha-《扇子与朦胧丝袜》-写真集-72P-
语画界_-Vol.270-芝芝Booty-《鲜艳吊裙与极致丝袜》-写真集-78P-
语画界_-Vol.271-Angela小热巴-《两套丝袜服饰下的绝美身姿》-写真集-101P-
语画界_-Vol.272-杨晨晨sugar-《白衬衫浴室淋漓湿身系列》-写真集-72P-
语画界_-Vol.273-Emily顾奈奈-《性感抹胸内衣-黑丝》-写真集-62P-
语画界_-Vol.274-何嘉颖-《吊带与黑丝镂空内衣系列》-写真集-110P-
语画界_-Vol.275-芝芝Booty-《古典韵味旗袍丝袜美腿翘臀》-写真集-84P-
语画界_-Vol.276-顾乔楠-《无法抵御的黑丝高开衩长裙》-写真集-76P-
语画界_-Vol.277-杨晨晨sugar-《典雅魅惑裙-黑丝美腿》-写真集-90P-
语画界_-Vol.278-允儿Claire-《OL眼镜女秘书》-写真集-76P-
语画界_-Vol.279-周思乔Betty-《身材凹凸惹火别致的美女》-写真集-74P-
语画界_-Vol.280-芝芝Booty-《镂空内衣-极致肉丝美腿》-写真集-79P-
语画界_-Vol.281-Carry-《直击心扉的眼镜秘书OL》-写真集-105P-
语画界_-Vol.282-杨晨晨sugar-《澳门风格系列之下的绝美娇躯》-写真集-98P-
语画界_-Vol.283-Carry-《性感皮裙下的丝袜美腿》-写真集-75P-
语画界_-Vol.284-Angela小热巴-《魅惑黑丝内衣与性感镂空吊带》-写真集-100P
语画界_-Vol.285-蓝夏Akasha-《浴室之下的淋漓湿身系列》-写真集-62P-
语画界_-Vol.286-杨晨晨sugar-《银色吊裙与朦胧丝袜》-写真集-83P-
语画界_-Vol.287-芝芝Booty-《西装吊裙-肉丝美腿》-写真集-82P-
语画界_-VOL.288-夏小雅---经典职场秘书OL装扮-78P-
语画界_-Vol.289-杨晨晨sugar-《黑色吊裙-丝袜美腿》-写真集-86P-
语画界_-Vol.290-周思乔Betty-《秘书眼镜OL系列》-写真集-70P-
语画界_-Vol.291-杨晨晨sugar-《私房魅惑》-写真集-75P-
语画界_-Vol.292-蓝夏Akasha-《极致美腿灵动销魂》-写真集-63P-
语画界_-Vol.293-杨晨晨sugar-《高筒靴与极致肉丝》-写真集-105P-
语画界_-Vol.294-Carry-《曼妙多姿的身段下美腿笔直》-写真集-72P-
语画界_-Vol.295-芝芝Booty-《精致的睡衣》-写真集-54P-
语画界_-Vol.296-杨晨晨sugar-《薄纱猩红内衣与魅惑蕾丝吊袜》-写真集-69P-
语画界_-Vol.297-夏小雅-《飒爽皮衣与极致黑丝》-写真集-68P-
语画界_-Vol.298-允儿Claire-《猩红的诱人内衣》-写真集-75P-
语画界_-Vol.299-周思乔Betty-《古典旗袍与魅惑黑丝系列》-写真集-60P-
语画界_-Vol.300-杨晨晨sugar-《牛仔裤之下的绝佳身材》-写真集-92P-
语画界_-Vol.301-芝芝Booty-《皮质的吊裙与魅惑黑丝》-写真集-79P-
语画界_-Vol.302-蓝夏Akasha-《皮衣的飒爽与牛仔裤》-写真集-91P-
语画界_-Vol.303-Emily顾奈奈-《浴室上演湿身的淋漓诱惑》　写真集-67P-
语画界_-Vol.304-Carry-《古典韵味旗袍-朦胧丝袜》　写真集-71P-
语画界_-Vol.305-杨晨晨sugar-《JK制服》　写真集-89P-
语画界_-Vol.306-芝芝Booty-《黑丝旗袍诱惑》　写真集-60P-
语画界_-Vol.307-周思乔Betty-《黑色主题服饰》　写真集-101P-
语画界_-Vol.308-气质女神-Carry-丝袜美腿　写真集-90P-
语画界_-Vol.309-夏小雅-《粉色的护士制服》　写真集-64P-
语画界_-Vol.310-杨晨晨sugar-《性感粉色女郎》　写真集-72P-
语画界_-Vol.311-Emily顾奈奈-《蕾丝吊袜私房》　写真集-66P-
语画界_-Vol.312-周思乔Betty-《魅惑吊裙与蕾丝黑丝》　写真集-67P-
语画界_-Vol.313-允儿Claire-《猩红典雅礼服与极致魅惑黑丝》　写真集-79P-
语画界_-Vol.314-芝芝Booty-《街拍OL》　写真集-75P-
语画界_-Vol.315-Carry-《猩红的蕾丝吊袜》　写真集-75P-
语画界_-Vol.316-夏小雅-《超低胸的礼服与极致黑丝》　写真集-58P-
语画界_-Vol.317-杨晨晨sugar-《时尚街拍系列》　写真集-85P-
语画界_-Vol.318-杨晨晨sugar---旗袍丝袜女郎诱惑-98P-
语画界_-Vol.319-芝芝Booty---剧情主题的职场制服系列-95P-
语画界_-Vol.320-冯木木LRIS---经典的白衬衫与猩红皮裙-74P-
语画界_-Vol.321-绯月樱-Cherry---性感黑丝吊袜美腿系列-52P-
语画界_-Vol.322-程程程----职业空乘制服系列-103P-
语画界_-Vol.323-杨晨晨sugar---街边偶遇酒后的美女-87P-
语画界_-Vol.324-言沫---黑色主题的眼镜OL制服系列-96P-
语画界_-Vol.325-何嘉颖---经典职场制服系列-63P-
语画界_-Vol.326-杨晨晨sugar---鲜艳的红裙街拍-73P-
语画界_-Vol.327-黄楽然---粉色西装-蕾丝吊袜-114P-
语画界_-Vol.328-杨晨晨sugar---澳门旅拍写真-75P-
语画界_-Vol.329-芝芝Booty---超短牛仔裤-极致网袜-74P-
语画界_-Vol.330-程程程----高跟鞋与筒袜的妩媚-53P-
语画界_-Vol.331-杨晨晨sugar---白色吊裙-肉丝袜写真-67P-
语画界_-Vol.332-绯月樱-Cherry---一袭职场秘书黑丝制服-53P-
语画界_-Vol.333-杨晨晨sugar---洗手台上的丝袜女郎诱惑-50P-
语画界_-Vol.334-夏小雅---古典韵味旗袍与极致丝袜系列-58P-
语画界_-Vol.335-芝芝Booty---性感肉丝玉足-50P-
语画界_-Vol.336-何嘉颖---性感肉丝高跟鞋美腿系列-82P-
语画界_-Vol.337-冯木木LRIS---青瓷色的内衣与极致黑丝-50P-
语画界_-Vol.338-杨晨晨sugar---车拍长腿女郎-89P-
语画界_-Vol.339-黄楽然---韵味旗袍与极致丝袜-102P-
语画界_-VOL.340-芝芝Booty---极致丝足美腿-豹纹内衣-53P-
语画界_-VOL.341-言沫---性感吊袜与极致丝袜-120P-
语画界_-VOL.342-绯月樱-Cherry---薄透服饰-极致黑丝美腿-52P-
语画界_-VOL.343-杨晨晨sugar---高马尾格子JK系列短裙-64P-
语画界_-Vol.344-芝芝Booty---街拍短裙写真-101P-
语画界_-Vol.345-程程程----极致到发光的丝袜美足-58P-
语画界_-Vol.346-冯木木LRIS---篮球女郎-47P-
语画界_-Vol.347-Carry---私人管家写真-81P-
语画界_-Vol.348-杨晨晨sugar---黑丝蕾丝吊袜与猩红镂空内衣极致魅惑-51P-
语画界_-Vol.349-芝芝Booty---经典眼镜OL-70P-
语画界_-Vol.350-夏小雅---职业制服与魅惑黑丝系列-66P-
语画界_-Vol.351-言沫---简约不失气质的吊裙与极致丝袜-109P-
语画界_-Vol.352-Carry---黑丝华丽长裙-66P-
语画界_-Vol.353-杨晨晨sugar---明亮通透的室外车拍系列-84P-
语画界_-Vol.354-芝芝Booty---性感动人的警花-66P-
语画界_-Vol.355-何嘉颖---皮裙与极致魅惑黑丝系列-50P-
语画界_-Vol.356-冯木木LRIS---绚丽光影与时尚车拍系列-110P-
语画界_-Vol.357-程程程----独特魅力的皮裙与极致黑丝-78P-
语画界_-Vol.358-杨晨晨sugar---魔鬼身材的运动内衣-70P-
语画界_-Vol.359-绯月樱-Cherry---性感黑丝吊袜美腿系列-64P-
语画界_-Vol.360-Dreamy小乔---性感黑丝吊袜写真-46P-
语画界_-Vol.361-黄楽然---华丽的吊裙与极致蕾丝吊袜-115P-
语画界_-Vol.362-言沫---一袭米色的服饰与极致朦胧丝袜-105P-
语画界_-Vol.363-杨晨晨sugar---古典气质的礼裙与现代性感黑丝-65P-
语画界_-Vol.364-冯木木LRIS---牛仔裤独有魅力与极致朦胧丝袜-119P-
语画界_-Vol.365-Carry---性感华丽长裙修饰曼妙身姿-80P-
语画界_-Vol.366-何嘉颖---性感朦胧肉丝美腿系列-52P-
语画界_-Vol.367-程程程----极致到发光的丝袜美足-82P-
语画界_-Vol.368-杨晨晨sugar---典雅吊裙与极致朦胧丝袜-61P-
语画界_-Vol.369-芝芝Booty---圆润酥胸与美臀暗香涌动-73P-
语画界_-Vol.370-安琪Yee---性感的职业装装扮-61P-
语画界_-Vol.371-Cherry绯月樱---优雅性感黑丝吊袜美腿系列-65P-
语画界_-Vol.372-杨晨晨sugar---典雅ol风华衣裹身-93P-
语画界_-Vol.373-言沫---黑色职场秘书OL制服系列-82P-
语画界_-Vol.374-程程程----黑丝美腿魅惑车拍系列-71P-
语画界_-Vol.375-绯月樱-Chery---紫色的极致性感丝袜美腿-48P-
语画界_-Vol.376-言沫---性感丝袜美腿-113P-
语画界_-Vol.377-杨晨晨sugar---极致魅丝袜美腿丝丝入魂-76P-
语画界_-Vol.378-周思乔Betty---情趣空乘制服系列-50P-
语画界_-Vol.379-陈梦babe---白衬衫、黑短裙职场秘书OL系列-63P-
语画界_-Vol.380-冯木木LRIS---精致的典雅镂空吊裙-75P-
语画界_-Vol.381-性感女神-杨晨晨sugar阳朔旅拍写真-83P-
语画界_-Vol.382-黄楽然---时尚与性感魅力兼具的车拍系列-111P-
语画界_-Vol.383-杨晨晨sugar---校园时代的清纯风格学生装-60P-
语画界_-Vol.384-冯木木LRIS---白色吊带与蕾丝内衣-90P-
语画界_-Vol.385-夏小雅---淡雅粉色连体衣与朦胧蕾丝袜-103P-
语画界_-Vol.386-程程程----独特的条纹黑丝吊袜-68P-
语画界_-Vol.387-言沫---时尚与靓丽户外车拍主题系列-105P-
语画界_-Vol.388-杨晨晨sugar---充满着幻想的空乘制服捆绑系列-54P-
语画界_-Vol.389-安琪Yee---白色连体衣包裹曼妙有致娇躯-88P-
语画界_-Vol.390-何嘉颖---诱人猩红连体衣与魅惑黑丝美腿系列-105P-
语画界_-Vol.391-杨晨晨sugar---精致镂空内衣-67P-
语画界_-Vol.392-Angela小热巴---猩红吊裙与极致魅惑丝袜在浴室中性感绽放-68P-
语画界_-Vol.393-杨晨晨sugar---街边偶遇身穿制服的晨晨-92P-
语画界_-Vol.394-何嘉颖---飒爽独特皮裙与极致魅惑黑丝系列-93P-
语画界_-Vol.395-言沫---简雅的职场制服系列-105P-
语画界_-Vol.396-夏小雅---黑色情趣内衣与蕾丝黑丝-80P-
语画界_-Vol.397-冯木木LRIS---黑丝典雅韵味旗袍与极致魅惑黑丝-101P-
语画界_-Vol.398-杨晨晨sugar---古韵典雅的旗袍与现代轻透蕾丝袜-53P-
语画界_-Vol.399-安琪Yee---性感的职业装装扮-77P-
语画界_-Vol.400-杨紫嫣Cynthia---黑色都市风格装扮-83P-
语画界_-Vol.401-芝芝Booty---独特魅力的情趣黑丝内衣-71P-
语画界_-Vol.402-梦梵---鲜艳的红色职场制服系列-63P-
语画界_-Vol.403-杨晨晨sugar---高贵典雅的贵妇主题-70P-
语画界_-Vol.404-何嘉颖---精致镂空蕾丝内衣私房写真-68P-
语画界_-Vol.405-周思乔Betty---魅惑吊带与蕾丝黑丝之下-66P-
语画界_-Vol.406-陈梦babe---日式风格的白色吊带系列-76P-
语画界_-Vol.407-杨紫嫣Cynthia---黑丝美腿空乘制服系列-82P-
语画界_-Vol.408-杨晨晨sugar---极致丝袜系朦胧美腿若隐若现-110P-
语画界_-Vol.409-杨晨晨sugar---古典旗袍丝袜美腿-91P-
语画界_-Vol.410-杨紫嫣Cynthia---古典韵味旗袍与现代性感丝袜系列-66P-
语画界_-Vol.411-何嘉颖---情趣内衣与极致魅惑黑丝系列-75P-
语画界_-Vol.412-安琪Yee---民国风的旗袍与现代蕾丝袜-63P-
语画界_-Vol.413-杨晨晨sugar---猩红的镂空内衣-黑丝美腿-52P-
语画界_-Vol.414-杨晨晨sugar---健身房内的性感女神-63P-
语画界_-Vol.415-杨紫嫣Cynthia---时尚街拍与魅惑私房主题-93P-
语画界_-Vol.416-言沫---一袭典雅礼裙轻裹她高挑苗条身段-63P-
语画界_-Vol.417-Cherry绯月樱---黑色主题的皮裙黑丝-53P-
语画界_-Vol.418-杨晨晨sugar---清纯可人的JK制服-52P-
语画界_-Vol.419-何嘉颖---薄透内衣与吊袜系列-43P-
语画界_-Vol.420-冯木木LRIS---一袭华丽典雅吊裙与朦胧丝袜-91P-
语画界_-Vol.421-杨晨晨sugar---白色的护士制服-51P-
语画界_-Vol.422-杨紫嫣Cynthia---户外车拍黑丝美腿主题系列-72P-
语画界_-Vol.423-杨晨晨sugar---高贵动人的天使-VS-魅惑极致的恶魔-61P-
语画界_-Vol.424-Carry---古典韵味旗袍-朦胧丝袜美腿-61P-
语画界_-Vol.425-芝芝Booty---针织绿色长裙-肉丝袜诱惑-58P-
语画界_-Vol.426-杨晨晨sugar---白色吊裙与朦胧丝袜-74P-
语画界_-Vol.427-杨紫嫣Cynthia---独特且魅惑的皮衣情趣内衣-50P-
语画界_-Vol.428-杨晨晨sugar---镂空面纱的之下的眼波-92P-
语画界_-Vol.429-杨晨晨sugar---黑丝的死库水与朦胧轻透丝袜-78P-
语画界_-Vol.430-豆瓣酱---经典的职场秘书OL系列-62P-
语画界_-Vol.431-Chery绯月樱---都市OL制服-50P-
语画界_-Vol.432-芝芝Booty---停车场邂逅-61P-
语画界_-Vol.433-杨晨晨sugar---率性的牛仔裤与蕾丝内衣-93P-
语画界_-Vol.434-黄楽然---高开衩的典雅礼裙与极致魅惑黑丝-125P-
语画界_-Vol.435-冯木木LRIS---一袭粉色典雅吊裙-75P-
语画界_-Vol.436-何嘉颖---黑色的经典职场制服系列-100P-
语画界_-Vol.437-杨晨晨sugar---圣诞主题写真-74P-
语画界_-Vol.438-杨晨晨sugar---圣诞主题写真-78P-
语画界_-Vol.439-豆瓣酱---浴室连体衣系列-67P-
语画界_-Vol.440-郑颖姗---蕾丝吊袜勾勒的美腿-68P-
语画界_-Vol.441-Chery绯月樱---都市OL礼裙-82P-
语画界_-Vol.442-杨晨晨sugar---成都旅拍写真-75P-
语画界_何嘉颖《低开衬衫与蕾丝吊袜下的婀娜姿态》-Vol.076-写真集-71P-
语画界_何嘉颖《低胸内衣下的婀娜有致身材》-Vol.140-写真集-56P-
语画界_何嘉颖《古典韵味旗袍-性感黑丝吊袜美腿系列》-Vol.079-写真集-67P-
语画界_何嘉颖《性感内衣黑丝美腿系列》-Vol.092-写真集-73P-
语画界_何嘉颖《性感内衣黑丝美腿系列》-Vol.145-写真集-67P-
语画界_何嘉颖《性感半透内衣与黑丝美腿系列》-Vol.253-写真集-69P-
语画界_何嘉颖《性感浴室真空吊带》-Vol.116-写真集-73P-
语画界_何嘉颖《性感肉丝吊袜美腿系列》-Vol.159-写真集-68P-
语画界_何嘉颖《性感黑丝吊袜美腿系列》-Vol.085-写真集-68P-
语画界_何嘉颖《性感黑丝吊袜美腿系列》-Vol.107-写真集-68P-
语画界_何嘉颖《性感黑丝吊袜美腿系列》-Vol.126-写真集-65P-
语画界_何嘉颖《性感黑丝吊袜美腿系列》-Vol.170-写真集-68P-
语画界_何嘉颖《浴室的淋漓与内衣的激凸诱惑》-Vol.185-写真集-60P-
语画界_何嘉颖《真空吊带下的婀娜有致身材》-Vol.097-写真集-66P-
语画界_何嘉颖《职业秘书装-性感肉袜美腿系列》-Vol.213-写真集-63P-
语画界_何嘉颖《职业装黑丝吊袜下性感角色装扮》-Vol.068-写真集-69P-
语画界_允儿Claire《性感牛仔裤黑丝吊袜》-Vol.172-写真集-82P-
语画界_允儿Claire《性感肉色丝袜下美腿》-Vol.186-写真集-72P-
语画界_允儿Claire《性感黑丝吊袜下美腿》-Vol.120-写真集-65P-
语画界_允儿Claire《美腿修长翘臀诱人》-Vol.181-写真集-72P-
语画界_允儿Claire《身材高挑凹凸别致》-Vol.176-写真集-61P-
语画界_冯木木LRIS《兔女郎制服》-Vol.056-写真集-60P-
语画界_冯木木LRIS《古典韵味旗袍-丝袜下的美腿与美臀》-Vol.158-写真集-59P
语画界_冯木木LRIS《可爱兔女郎》-Vol.121-写真集-60P-
语画界_冯木木LRIS《性感白丝吊袜-高叉系列》-Vol.075-写真集-63P-
语画界_冯木木LRIS《旗袍丝袜美腿翘臀》-Vol.231-写真集-73P-
语画界_冯木木LRIS《无法抵御的性感丝袜美腿》-Vol.053-写真集-59P-
语画界_冯木木LRIS《无法抵御的性感产物》-Vol.032-写真集-61P-
语画界_冯木木LRIS《白衬衫-黑丝袜》-Vol.249-写真集-80P-
语画界_冯木木LRIS《私房美臀魅惑》-Vol.039-写真集-60P-
语画界_冯木木LRIS《秘书制服美腿美臀》-Vol.207-写真集-108P-
语画界_冯木木LRIS《空乘制服教室扮演-黑丝吊袜》-Vol.100-写真集-74P-
语画界_冯木木LRIS《镂空内衣-丝袜美腿系列》-Vol.087-写真集-60P-
语画界_冯木木LRIS《黑丝吊袜同暗黑精灵》-Vol.146-写真集-73P-
语画界_冯木木LRIS《黑丝暗黑精灵》-Vol.006-写真集-81P-
语画界_冯木木LRIS《黑丝美腿诱惑》-Vol.065-写真集-68P-
语画界_冯木木LRIS《黑丝职场秘书》-Vol.009-写真集-65P-
语画界_冯木木《丝袜美腿的魅力》-Vol.021-写真集-56P-
语画界_周于希Sandy《层层深入的外景车拍系列》-Vol.125-写真集-59P-
语画界_周于希Sandy《雪中有佳人》-Vol.007-写真集-47P-
语画界_大熙《御姐风情诱惑》-Vol.113-写真集-76P-
语画界_大熙《御姐风情诱惑》-Vol.216-写真集-62P-
语画界_安可儿《镂空内衣与浴袍》-Vol.136-写真集-42P-
语画界_安琪-Yee《丝袜美腿朦胧极致诱惑》-Vol.240-写真集-78P-
语画界_安琪Yee《黑丝OL职业装》-Vol.203-写真集-63P-
语画界_小尤奈《巨乳女神小尤奈马代新图》-Vol.070-写真集-49P-
语画界_小尤奈《巨大的性感魅力》-Vo.029-写真集-52P-
语画界_小尤奈《巨大的诱惑魅力》-Vol.111-写真集-50P-
语画界_小沫琳《性感从胸前至上而下的肆意蔓延》-Vol.030-写真集-71P-
语画界_小沫琳《性感从胸前至上而下的肆意蔓延》-Vol.060-写真集-50P-
语画界_小沫琳《性感从胸前至上而下的肆意蔓延》-Vol.102-写真集-62P-
语画界_小沫琳《雪白丰满的美胸与诱人翘臀》-Vol.069-写真集-60P-
语画界_小沫琳《雪白丰满的美胸与诱人翘臀》-Vol.086-写真集-55P-
语画界_张雨萌《白色与黑色的的内衣》-Vol.003-写真集-44P-
语画界_张雨萌《黑丝透视的魅惑与湿身的淋漓》-Vol.091-写真集-56P-
语画界_月音瞳《性感旗袍下的美胸与秀腿十足诱人》-Vol.082-写真集-46P-
语画界_月音瞳《秘书制服黑丝吊袜》-Vol.254-写真集-49P-
语画界_月音瞳《秘书制服黑丝吊袜美胸与秀腿》-Vol.096-写真集-53P-
语画界_月音瞳《蕾丝袜秀腿与敞开的胸口雪白诱人》-Vol.142-写真集-50P-
语画界_月音瞳《镂空内衣下的美胸与美腿》-Vol.108-写真集-50P-
语画界_杨晨晨sugar《一场危险关系的来临》-Vol.067-写真集-65P-
语画界_杨晨晨sugar《一场的视觉享受的来临》-Vol.031-写真集-55P-
语画界_杨晨晨sugar《一袭镂空黑丝魅惑》-Vol.013-写真集-66P-
语画界_杨晨晨sugar《人浴出新妆洗》-Vol.081-写真集-65P-
语画界_杨晨晨sugar《从山岚起伏的胸脯到修长秀美的玉足》-Vol.035-写真集-60P-
语画界_杨晨晨sugar《优雅的服饰-性感内衣》-Vol.219-写真集-61P-
语画界_杨晨晨sugar《华丽的束胸吊袜》-Vol.010-写真集-66P-
语画界_杨晨晨sugar《古典旗袍-黑丝高跟系列》-Vol.247-写真集-85P-
语画界_杨晨晨sugar《古典韵味的旗袍丝袜美腿》-Vol.114-写真集-65P-
语画界_杨晨晨sugar《圣诞主题》-Vol.059-写真集-45P-
语画界_杨晨晨sugar《圣诞女神》-Vol.221-写真集-71P-
语画界_杨晨晨sugar《媚态十足的视觉盛宴》-Vol.054-写真集-62P-
语画界_杨晨晨sugar《媚态的内衣-黑丝美腿魅惑》-Vol.189-写真集-61P-
语画界_杨晨晨sugar《完美凹凸别致的身材》-Vol.084-写真集-52P-
语画界_杨晨晨sugar《室外草帽女孩主题》-Vol.169-写真集-63P-
语画界_杨晨晨sugar《室外车拍主题系列》-Vol.178-写真集-66P-
语画界_杨晨晨sugar《室外车拍主题系列》-Vol.230-写真集-100P-
语画界_杨晨晨sugar《性感吊裙湿身系列》-Vol.234-写真集-64P-
语画界_杨晨晨sugar《性感旗袍丝袜美腿》-Vol.129-写真集-58P-
语画界_杨晨晨sugar《性感蕾丝丝袜尤物》-Vol.094-写真集-50P-
语画界_杨晨晨sugar《户外镂空内衣与薄纱吊裙系列》-Vol.099-写真集-55P-
语画界_杨晨晨sugar《新春福利特辑》-Vol.243-写真集-110P-
语画界_杨晨晨sugar《旗袍与黑丝的中秋礼物》-Vol.152-写真集-57P-
语画界_杨晨晨sugar《束胸装-丝袜诱惑》-Vol.209-写真集-73P-
语画界_杨晨晨sugar《极致丝袜玉足》-Vol.224-写真集-69P-
语画界_杨晨晨sugar《极致如梦的黑丝美腿诱惑》-Vol.012-写真集-54P-
语画界_杨晨晨sugar《极致销魂的黑丝美臀魅惑》-Vol.040-写真集-66P-
语画界_杨晨晨sugar《比基尼湿身》-Vol.124-写真集-58P-
语画界_杨晨晨sugar《浴室内完美凹凸别致的身材》-Vol.109-写真集-55P-
语画界_杨晨晨sugar《浴室高叉湿身尤物》-Vol.089-写真集-60P-
语画界_杨晨晨sugar《清纯甜美-性感诱人》-Vol.204-写真集-58P-
语画界_杨晨晨sugar《清纯的学生装到湿身性感蕾丝内衣》-Vol.184-写真集-73P
语画界_杨晨晨sugar《清透的光线搭配白衬衫丝袜装扮》-Vol.148-写真集-66P-
语画界_杨晨晨sugar《灵动销魂的黑丝美腿魅惑》-Vol.048-写真集-60P-
语画界_杨晨晨sugar《灵动销魂的黑丝美腿魅惑》-Vol.062-写真集-60P-
语画界_杨晨晨sugar《灵动销魂的黑丝美腿魅惑》-Vol.119-写真集-75P-
语画界_杨晨晨sugar《灵动销魂的黑丝美腿魅惑》-Vol.138-写真集-55P-
语画界_杨晨晨sugar《牛仔裤包裹的美腿》-Vol.228-写真集-63P-
语画界_杨晨晨sugar《玉女浴出新妆洗》-Vol.025-写真集-65P-
语画界_杨晨晨sugar《白衬衫-黑丝袜》-Vol.214-写真集-53P-
语画界_杨晨晨sugar《皮衣的飒爽与内衣的魅惑》-Vol.077-写真集-63P-
语画界_杨晨晨sugar《皮鞭与皮衣的狂野魅惑》-Vol.237-写真集-80P-
语画界_杨晨晨sugar《眼镜OL与蕾丝吊袜的诱惑》-Vol.164-写真集-90P-
语画界_杨晨晨sugar《知性优雅的秘书OL》-Vol.005-写真集-70P-
语画界_杨晨晨sugar《第二部圣诞主题》-Vol.225-写真集-103P-
语画界_杨晨晨sugar《绝代佳人诱人姿态》-Vol.194-写真集-70P-
语画界_杨晨晨sugar《美臀玉足的极致诱惑》-Vol.233-写真集-135P-
语画界_杨晨晨sugar《美艳不可方物》-Vol.020-写真集-71P-
语画界_杨晨晨sugar《蕾丝控福利》-Vol.051-写真集-58P-
语画界_杨晨晨sugar《镂空内衣与极致丝袜的魅惑》-Vol.157-写真集-78P-
语画界_杨晨晨sugar《镂空内衣与诱人黑丝视觉魅惑》-Vol.162-写真集-85P-
语画界_杨晨晨sugar《韵味旗袍-性感蕾丝吊袜系列》-Vol.241-写真集-120P-
语画界_杨晨晨sugar《香槟色睡衣-奶牛内衣系列》-Vol.143-写真集-55P-
语画界_杨晨晨sugar《马尔代夫旅拍泳池》-Vol.072-写真集-45P-
语画界_杨晨晨sugar《高开的长裙-销魂的黑丝美腿魅惑》-Vol.174-写真集-71P-
语画界_杨晨晨sugar《魅惑的吊袜与解开的内衣》-Vol.153-写真集-80P-
语画界_杨晨晨sugar《魅惑销魂入骨的私房诱惑》-Vol.199-写真集-104P-
语画界_杨晨晨sugar《鲜艳的吊裙下一如女神媚态更为明艳动人》-Vol.044-写真集-56P-
语画界_杨晨晨sugar《黑丝与捆绑蒙面的激情诱惑》-Vol.238-写真集-90P-
语画界_杨晨晨sugar《黑丝内衣的魅惑与丝袜的朦胧诱惑》-Vol.134-写真集-59P
语画界_杨晨晨sugar《黑丝网袜性感护士制服》-Vol.252-写真集-103P-
语画界_杨晨晨sugar《黑丝美腿撕扯诱惑》-Vol.104-写真集-65P-
语画界_楚恬Olivia《性感内衣》-Vol.023-写真集-62P-
语画界_模特猫宝《新机构成立第一刊》-Vol.001-写真集-52P-
语画界_沈蜜桃miko《内衣、厨娘与和服的百变性感魅惑》-Vol.137-写真集-50P-
语画界_沈蜜桃miko《厨娘与女友视角主题》-Vol.080-写真集-46P-
语画界_甜心菜《身材高挑曼妙丝袜美腿》-Vol.131-写真集-62P-
语画界_甜心菜《身材高挑曼妙丝袜美腿》-Vol.165-写真集-66P-
语画界_甜心菜《金发小秘书》-Vol.123-写真集-85P-
语画界_程程程-《吊带朦胧丝袜主题系列》-Vol.210-写真集-108P-
语画界_程程程-《娇柔动人的粉护士》-Vol.218-写真集-54P-
语画界_程程程-《职业秘书OL装扮》-Vol.201-写真集-98P-
语画界_绯月樱-Cherry《-别墅，大海，美女--风景无限！》-Vol.071-写真集-56P-
语画界_绯月樱-Cherry《户外美臀到漓尽致的浴室湿身系列》-Vol.155-写真集-66P-
语画界_绯月樱-Cherry《淋漓尽致的浴室湿身系列》-Vol.118-写真集-55P-
语画界_绯月樱-Cherry《诱人十足的衬衫内衣-浴室湿身系列》-Vol.183-写真集-78P-
语画界_绯月樱_Cherry《诱惑的吊袜》-Vol.027-写真集-70P-
语画界_绯月樱_Cherry《诱惑黑丝秀》-Vol.133-写真集-64P-
语画界_绯月樱-Cherry《诱惑黑丝秀人诱人魅力》-Vol.061-写真集-60P-
语画界_绯月樱-Cherry《雪峰高耸挺拔-圆润翘臀若隐若现》-Vol.090-写真集-50P-
语画界_绯月樱-Cherry《魅惑的浴室湿身系列》-Vol.147-写真集-65P-
语画界_芝芝Booty《典雅吊裙与魅惑黑丝系列》-Vol.232-写真集-76P-
语画界_芝芝Booty《古典韵味旗袍-诱人礼服》-Vol.192-写真集-72P-
语画界_芝芝Booty《可比拟的翘臀下黑丝美腿》-Vol.101-写真集-62P-
语画界_芝芝Booty《姿飒爽的空乘》-Vol.226-写真集-81P-
语画界_芝芝Booty《室外剧情车拍系列》-Vol.168-写真集-56P-
语画界_芝芝Booty《层层深入的室外剧情车拍系列》-Vol.156-写真集-68P-
语画界_芝芝Booty《性感丝袜酥胸翘臀无比销魂入骨》-Vol.110-写真集-71P-
语画界_芝芝Booty《性感内衣》-Vol.122-写真集-41P-
语画界_芝芝Booty《性感吊裙下黑丝吊袜》-Vol.128-写真集-50P-
语画界_芝芝Booty《性感黑丝眼镜OL》-Vol.179-写真集-75P-
语画界_芝芝Booty《教师制服的黑丝美腿》-Vol.095-写真集-63P-
语画界_芝芝Booty《旗袍丝袜下的的芊芊美腿与美臀》-No.220-写真集-80P-
语画界_芝芝Booty《无可比拟的翘臀下黑丝美腿》-Vol.049-写真集-60P-
语画界_芝芝Booty《无可比拟的翘臀下黑丝美腿》-Vol.063-写真集-54P-
语画界_芝芝Booty《无可比拟的翘臀下黑丝美腿》-Vol.073-写真集-62P-
语画界_芝芝Booty《皮衣下的凹凸别致与酥胸丰满高耸》-Vol.151-写真集-61P-
语画界_芝芝Booty《私房浴出淋漓魅惑》-Vol.105-写真集-60P-
语画界_芝芝Booty《紧身牛仔裤下的美腿翘臀》-Vol.197-写真集-114P-
语画界_芝芝Booty《翘臀下黑丝美腿》-Vo.028-写真集-51P-
语画界_芝芝Booty《职业装黑丝美臀诱惑》-Vol.205-写真集-72P-
语画界_芝芝Booty《透视装高跟丝袜系列》-Vol.245-写真集-100P-
语画界_芝芝Booty《酥胸丰满高耸-臀部圆滚而翘挺》-Vol.042-写真集-50P-
语画界_芝芝Booty《酥胸翘臀美臀》-Vol.163-写真集-60P-
语画界_芝芝Booty《酥胸翘臀美臀的芝芝》-Vol.018-写真集-62P-
语画界_芝芝Booty《酥胸翘臀美臀精彩呈现》-Vol.144-写真集-70P-
语画界_芝芝Booty《高贵典雅制服与魅惑网袜系列》-Vol.239-写真集-72P-
语画界_芝芝Booty《黑丝美腿翘臀》-Vol.255-写真集-66P-
语画界_芝芝Booty《黑丝翘臀诱惑》-Vol.130-写真集-62P-
语画界_芝芝Booty《黑丝职业装下的美腿翘臀》-Vol.215-写真集-70P-
语画界_萌汉药baby很酷《薄若轻纱暗黑情趣魅惑》-Vol.050-写真集-57P-
语画界_萌汉药baby很酷《魅惑诱人黑丝吊袜美臀秀腿》-Vol.078-写真集-60P-
语画界_诗诗kiki《白衬衫与黑丝袜的职场OL》-Vol.173-写真集-75P-
语画界_诗诗kiki《韵味旗袍-极致黑丝诱惑》-Vol.187-写真集-100P-
语画界_陈良玲Carry《如描似削身材，怯雨羞云情意》-Vol.033-写真集-51P-
语画界_陈良玲Carry《性感的和服-蕾丝美腿私房魅惑》-Vol.014-写真集-53P-
语画界_陈良玲Carry《蓝色妖姬》-Vol.250-写真集-100P-
语画界_陈良玲Carry《黑丝美腿》-Vol.202-写真集-87P-
语画界_雅雯《事业线低开的性感吊裙》-Vol.015-写真集-55P-
语画界_雅雯《无法抗拒的秘书OL角色扮演》-Vol.057-写真集-50P-
语画界_顾桥楠《让人无法抵御的秘书黑丝OL》-Vol.195-写真集-95P-
语画界_顾桥楠《高贵的抹胸礼服与魅惑黑丝》-Vol.171-写真集-87P-
语画界_高挑美女-大熙《御姐风情诱惑》-Vol.175-写真集-64P-
语画界_黄楽然《凹凸别致曲线春光乍泄》-Vol.036-写真集-52P-
语画界_黄楽然《浪漫梦幻蕾丝薄纱与魅惑镂空湿身诱惑》-Vol.047-写真集-60P-
EOF;


$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$dryrun = 0;
$org_name = '语画界';
$org_name_en = 'XiaoYu';

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
        $vol = 'no.'.$v_arr[0];

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
                // if ( is_file($origin_file_full) && @is_array(getimagesize($origin_file_full)) ) {
                //     $images[] = $file;
                // }
            }
            // natsort($images);
            
            // if($already_has_thumbnail) {
            //     echo "---- Already has a thumbnail.jpg \n\n";
            // }
            // else {
            //     // if((int)$vol < 37) {
            //     //   $thumb = $images[0];
            //     // }
            //     // else {
            //         $thumb = $images[count($images) - 1];
            //     // }
            //     echo 'rename('. $the_full_path . '/' . $thumb . ', ' . $the_full_path . '/thumbnail.jpg' .  "\n\n";
            //     if(!$dryrun) rename($the_full_path . '/' . $thumb , $the_full_path . '/thumbnail.jpg');    
            // }

            // rename current folder to the origin folder name
            if(!empty($origin['main'] )) {
                $x = explode(' ', $folder_name);
                $last = $x[1];

                $vol = str_replace('no.', '', $vol);
                
                $new_folder_name = $org_name_en.$org_name.'-'. ucfirst($vol) . '-'.$origin['model'] . '-' . $origin['main'] . '-'.$last;
                // $new_folder_name = $org_name_en.$org_name.'-'. strtoupper($vol) . '-' . $origin['main'];
                echo "rename $the_full_path to $folder_full_path/$new_folder_name\n\n";
                if(!$dryrun) rename($the_full_path, $folder_full_path . '/'.$new_folder_name);

                // $desc = str_replace('-', ' ', $new_folder_name);
                // $desc .= '。欢迎下载高清无水印套图。';
                // echo "Processing " . $the_full_path . "/desc.txt \n";
                // if(!$dryrun) file_put_contents($folder_full_path . '/'.$new_folder_name.'/desc.txt', $desc);
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
            // echo "l_folder: $l_folder_name \n"; exit;
            
            if(strpos($l_folder_name, $vol_num) !== false) {
                $folder_info['full_path'] = $origin_folders  . '/' . $folder_name;

                $l_folder_name = sanatizeCN($l_folder_name);
                $l_folder_name = str_replace('_-','_',$l_folder_name);
                $l_folder_name = str_replace('《','-',$l_folder_name);
                $l_folder_name = str_replace('》','-',$l_folder_name);
                $l_folder_name = str_replace('---','-',$l_folder_name);
                $l_folder_name = str_replace('--','-',$l_folder_name);
                $folder_info['name'] = $l_folder_name;

                $l_folder_name = mapModelNames($l_folder_name);
                $l_folder_name = str_replace($org_name.'-',$org_name.'_', $l_folder_name);
                
                $tt = find_between($l_folder_name, $org_name.'_', '-');
                if(str_starts_with($tt[0], 'no.')) {
                    $ss = find_between($l_folder_name, '-', '-');
                    $folder_info['model'] = my_mb_ucfirst(sanatizeCN($ss[0]));
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
                if(empty($main)) {
                    $xx = explode('-', $folder_name);
                    $main = $xx[2];
                }
                $main = empty($main) ? '' : '《' .my_mb_ucfirst(sanatizeCN($main))  . '》';
                $folder_info['main'] = $main;
                continue;
            }
        }
    }

    return $folder_info;
}
