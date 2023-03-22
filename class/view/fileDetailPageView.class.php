<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class fileDetailPageView extends ViewCore {

  private $keywords = ['尤妮丝', '孟狐狸', '卓娅祺', '妲己', '杨晨晨', '小热巴', '艾莉', '王语纯', '徐微微', '玛鲁娜', '芝芝', '筱慧', 'Miko酱', '尹菲', '黄楽然', '艾小青', '若兮', '闫盼盼', '刘钰儿', '柚木', '阿朱', '土肥圆', '傲娇萌萌', '心妍小公主', '萌宝儿', '周妍希', '糯美子', '李可可', '林美惠子', '小狐狸', '乔依琳', '宋KiKi', '小尤奈', '绯月樱', '萌汉药', '易阳', '沈梦瑶', '赵小米', '冯木木', '刘飞儿', '夏美酱', '许诺', '妲己', '张雨萌', '柳侑绮', '小九月', '悦爷妖精', '徐cake', '赵梦洁', '王馨瑶', '米妮', '小甜心', '娜露', '萌琪琪', '陈思琪', '孙梦瑶', '温心怡', 'sukki', '可儿', '爱丽莎', '李丽莎', '梦心玥', '艾霓莎', 'E杯奶茶', '楚楚', '苍井优香', '唐琪儿', '李梓熙', '李雅', '熊吖', '刘娅希', '兜豆靓', '宅兔兔', '雪千寻', '赵惟依', '沈佳熹', '黄可', '多香子', '纯小希', '娜依灵儿', '小探戈', '朱可儿', '梁莹', '王乔恩', '周心怡', '婕西儿', '李妍曦', '白甜', '佘贝拉', '乔柯涵', 'Angela喜欢猫', '李筱乔', '夏小秋', '刘雪妮', '七宝', '程小烦', '于大乔', '王婉悠', '于姬', '夏瑶', '于大小姐', '顾欣怡', '青树', '麦苹果', '沐子熙', '妮儿', '本能', '陆瓷', '谭晓彤', '木木', '叶佳颐', '信悦儿', '西希白兔', '韩子萱', '伊莉娜', '李宓儿', '绮里嘉', '穆菲菲', '李雪婷', '王瑞儿', '梓萱', '李七喜', '潘娇娇', '嘉宝贝儿', '松果儿', '月音瞳', '栗子Riz', '苏可可', '谢芷馨', '笑笑', '夏茉', '战姝羽', '邹晶晶', '可儿', '盼盼已鸠', '凯竹', '李凌子', '李思宁', '韩恩熙', '陈秋雨', '欣杨', '索菲', '慕羽茜', '陈雅漫', '丽莉', '张优', '刘雪妮', '陈宇曦', '羽住', '杨伊', '黄歆苑', '何晨曦', '久久', '猫宝', '唐思琪', '考拉', '晓梦', '白一晗', '恩一', '刘奕宁', '奶昔', '丁筱南', '杨漫妮', '卤蛋luna', '米娅Miya', 'Miki兔', '顾灿', '白沫', '小沫琳', '雪儿', '妤薇', '大城小爱', '葉晶金', '唐婉儿', '楚恬', '桃子', 'Annie', '童安琪', '铃木美咲', '木奈奈', '顾奈奈', '果儿Victoria', '林文文', '陈宇曦', '周于希', '三上悠亚', '冲田杏梨'];



  public function preDisplay() {
    parent::preDisplay();

    $isHighlighted = $this->isHighlightedModal($this->data['file']['title']);

    // Set title in header
    $title =$isHighlighted ? $this->data['file']['title'] . ' - 无圣光大尺度' : $this->data['file']['title'];
    
    $this->setHeader($title, 'title');

    // Set meta description
    $extraDesc = $isHighlighted ? ' - 无圣光大尺度' : '';
    $this->data['meta_desc'] = $this->data['file']['title'] . $extraDesc . ' - ' .  $this->data['meta_desc'];

    // Set meta keyword
    $extraKeywords = $isHighlighted ? ', 无圣光, 大尺度' : '';
    $this->data['meta_keywords'] = implode(', ', titleToKeywords($this->data['file']['title'])) . $extraKeywords . ', ' . $this->data['file']['tags'] . ',' . $this->data['meta_keywords'];

    $this->data['meta_robots'] = empty($_GET['at']) || $_GET['at'] <= 10 ? '' : 'noindex, nofollow';
    
  }

  private function isHighlightedModal($title) {
    foreach($this->keywords  as $model) {
      if(stripos($title, $model) !== false) {
        return true;
      }
    }

    return false;
  }
}