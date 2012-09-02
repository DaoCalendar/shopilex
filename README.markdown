##关于Shopilex
Shopilex是基于Opencart的新分支,主要为中文用户而改进和开发.Shopilex将根据自己的Roadmap去开发和改进,为广大的用户提供更好更强大并且易于使用的网店系统.<br/><br/>

同时,Shopilex也是国内为数不大的开源网店系统.使用Shopilex即可省去商业授权的费用,开放的源代码也提供了后继改进优化的可能性.<br/><br/>

我们衷心的希望所有Shopilex的用户可以更快更好的开展其线上业务,也希望更多的人使用并且加入Shopilex推广和开发中来.只有用户的支持,Shopilex才能走得更远.<br/><br/>


###Shopilex适合做什么?


Shopilex是一个独立的中小型B2C网店,用于建立独立的网店平台,区别于淘宝等第三方电商网店,独立网店系统具有更强的自由度,同时也可以作为品牌运营.<br/><br/>

###Shopilex在线演示以及视频
在线演示地址: <br/>
[Shopilex官方网站](http://www.shopilex.com/ "Shopilex官方网站")<br/><br/>

视频演示地址: <br/>
[Shopilex 2.0 简介](http://v.youku.com/v_show/id_XNDQ1MjM3MDQw.html "Shopilex 2.0 简介")<br/>
[Shopilex 2.0 后台视频](http://v.youku.com/v_show/id_XNDQ1MjM2Mjcy.html "Shopilex 2.0 后台操作")<br/><br/>

###Shpoilex的安装和使用
安装Shopilex,你需要安装和配置PHP+Mysql的环境.以下是需要满足的安装条件:

**php.ini配置以适应以下安装需求:**<br/>
* PHP Version:	5.0+	
* Register Globals:	Off	
* Magic Quotes GPC:	Off	
* File Uploads:	On	
* Session Auto Start:	Off
<br/>
<br/>

**安装环境包含以下扩展:**<br/>
* MySQL:	On	
* GD:	On	On	
* cURL:	On	
* ZIP:	On

**保证安装目录处于可写状态**<br/><br/>


推荐使用LAMP或者LANMP环境,即Lunix,Apache,Nginx,以获得最佳使用体验.
<br/><br/>

**执行安装:**
将下载后的ZIP包解压到网站的根目录(或者你需要安装的目录下),访问: 网站目录/install,
然后根据安装界面的提示,一步步往下填写相对应的信息并且点击下一步即可.

安装图文教程可以访问: [Shopilex官方论坛](http://bbs.shopilex.com/ "Shopilex官方论坛")<br/><br/>

**Shopilex能良好的兼容目前市面的主流浏览器.网店管理员推荐使用Chrome,Firefox 或Safari,以获得更好的后台使用体验.**


###Shpoilex的模板开发
Shopilex是基于MVC设计开发的,设计和开发模板你需要具备HTML,CSS的编程知识.<br/><br/>
Shopilex的主体页面结构划分为:
头部,内容(内容分左,中,右三栏布局),内容上部,内容下部,底部.<br/><br/>
开发和设计Shopilex的模板,你需要了解Shopilex布局概念和模块的概念.<br/><br/>
**什么是布局**<br/>
Shopilex可以配置不同的路由,比如你的访问链接index?route=commom/home,去映射不同的布局方式.布局主要用几个部分组成:内容的上部,内容的下部,左边栏,右边栏.

你可以通过配置不用的路由映射到对应的布局上去.实现了布局设置后,你就可以通过模块配置功能,实现 模块显示控制的功能了.

比如,设定了产品页面的布局(Product,对应的路由是product/product,在这个布局上显示商品分类导航,在首页布局(路由为:common/home)则不显示.这样用户只有在访问Product布局的时候才能看到商品分类导航,其他的页面就看不到这个的.<br/><br/>
**什么是模块**<br/>
你可以在后台的 扩展功能 -> 模块配置,开启和配置不同的模块.模块显示主要根据布局和选择显示的位置,出现在不同的布局和位置上面.<br/>


了解了以上的概念,对开发Shopilex的模板会有一定的帮助.更多的帮助和教程信息,请关注[Shopilex官方网站](http://www.shopilex.com/ "Shopilex官方网站").<br/><br/>


###如何获取Shopilex最新更新信息
关注我们的[Shopilex官方微薄](http://weibo.com/shopilex/ "Shopilex官方微博"),获取最新的更新信息,我们会定期在微博上发布我们最新的更新和Bug修复信息.<br/><br/>

###如何帮助Shopilex更好的发展
Shopilex是开源产品,用户可以免费使用,目前我们没有明确的盈利模式.如果你觉得Shopilex还不错,欢迎你转发我们的微博,或者把Shopilex分享给更多的人,如果你是开发者,欢迎你加入开发Shopilex扩展和代码完善中来.<br/>

只有更多的人使用和支持,Shopilex才能走得更远.<br/><br/>

###听听Shopilex用户怎么说
>Shopilex系统，页面简洁，后台操作不复杂。基本功能完备，用户体验好！主要是开源，希望一直坚持下来。我们非常支持！


<br/><br/>
当前版本:2.0 Beta

开源协议: GNU General Public Licence v3



