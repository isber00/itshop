#商品类型表
create table it_type(
      id tinyint unsigned primary key auto_increment,
      type_name varchar(32) not null comment '商品类型的名称',
      index (type_name)
)engine myisam charset utf8;

#商品的属性表
create table it_attribute(
      id tinyint unsigned primary key auto_increment,
      type_id tinyint not null comment '商品类型的id',
      attr_name varchar(32) not null comment '属性的名称',
      attr_type tinyint  not null default 0 comment '属性的类型，0:表示唯一属性，1则表示是单选属性',
      attr_input_type  tinyint  not null default 0 comment '属性值的输入方式 0:表示手工输入，1则是列表选择',
      attr_value varchar(64) not null default '' comment '属性的默认值，列表选择使用',
      index (type_id)
)engine myisam charset utf8;


#商品的栏目表
#商品的属性表
create table it_category(
      id smallint unsigned primary key auto_increment,
      cat_name varchar(32) not null comment '栏目的名称',
      parent_id smallint unsigned not null default 0 comment '父级栏目的id'
)engine myisam charset utf8;

#完成商品表
create table it_goods(
      id smallint unsigned primary key auto_increment,
      goods_name varchar(32) not null comment '商品的名称',
      cat_id  smallint unsigned not null comment '商品所属栏目的id',
      goods_type tinyint unsigned not null comment '商品类型的id',
      goods_sn  varchar(32) not null comment '商品的货号',
      shop_price decimal(9,2) not null default 0.0 comment '商品的本店价格',
      market_price decimal(9,2) not null default 0.0 comment '商品的市场价格',
      goods_number smallint  not null default 0 comment '商品的库存',
      seotitle varchar(32) not null default '' comment 'seo标题，利用搜索引擎的',
      goods_desc varchar(128) not null default '' comment '商品的描述',
      goods_ori varchar(64)  not null default ''  comment '商品的原图',
      goods_thumb varchar(64) not null default '' comment '商品的小图',
      goods_img varchar(64) not null default '' comment '商品的中图',
      is_best tinyint  not null default 0  comment '是否是精品，1表示为精品，0表示不是',
      is_new tinyint  not null default 0  comment '是否是新品，1表示为新品，0表示不是',
      is_hot tinyint  not null default 0  comment '是否是热卖，1表示为热卖，0表示不是',
      is_sale tinyint  not null default 0  comment '是否上架，1表示为上架销售，0表示不是',
    add_time int not null default 0 comment '商品的添加时间'
)engine myisam charset utf8;
#商品属性表
create table it_goods_attr(
         id smallint unsigned primary key auto_increment,
         goods_id smallint not null comment '商品的id',
         attr_id tinyint unsigned not null  comment '属性的id',
         attr_value varchar(10) not null comment '属性的值'
)engine myisam charset utf8;

mysql_query('START TRANSACTION');
mysql_query('ROLLBACK');	
mysql_query('COMMIT');	
#建立一个会员表
create table it_user(
         id smallint unsigned primary key auto_increment,
         username varchar(32) not null comment '会员的用户名',
         password   char(32) not null comment '会员的密码',
         email   varchar(32) not null comment '会员的邮箱'   
)engine myisam charset utf8;

#创建一个购物车的表
create table it_cart(
         id smallint unsigned primary key auto_increment,
         goods_id smallint not null comment '商品的id',
         goods_attr_id varchar(32) not null default '' comment 'goods_attr表属性的id多个用逗号隔开',
         goods_number tinyint not null comment '购买数量',
         user_id smallint not null comment '登录用户的id'  
)engine myisam charset utf8;
#创建一个订单信息表
create table it_order(
         id smallint unsigned primary key auto_increment,
         user_id smallint unsigned not null comment '登录用户的id',
         order_sn varchar(32) not null comment '订单号',
         total_price  decimal(12,2) not null comment '订单的总金额',
         consignee  varchar(32) not null comment '收货人的姓名',
         address varchar(64) not null comment '收货人的地址',
         mobile  char(11)  not null comment '收货人的电话',
         pay_status tinyint not null default 0 comment '支付的状态0表示未支付，1表示已经支付',
         shipping  varchar(10) not null comment '配送方式',
         payment  varchar(10) not null comment '支付方式'
)engine myisam charset utf8;
#创建一个订单商品表
create table it_order_goods(
         id int unsigned primary key auto_increment,
         order_id smallint unsigned not null comment '订单的id',
         goods_id smallint not null comment '商品的id',
         goods_attr_id varchar(32) not null default '' comment '商品属性id',
         goods_number tinyint unsigned not null comment '购买数量',
         goods_price  decimal(10,2) not null comment '购买商品的单价'
)engine myisam charset utf8;
#创建一个收货人的信息表
create table it_address(
         id smallint unsigned primary key auto_increment,
         user_id  smallint unsigned not null comment '登录用户的id',
         consignee  varchar(32) not null comment '收货人的姓名',
         tel varchar(12) not null comment '收货人的电话',
          mobile  char(11)  not null comment '收货人的移动电话',
          address varchar(64) not null comment '收货人的地址',
          post  char(6) not null comment '收货人的邮编'
)engine myisam charset utf8;