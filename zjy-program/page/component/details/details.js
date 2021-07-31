// page/component/details/details.js
const app = getApp()
Page({
  data:{
    goods: {
      id: 1,
      image: '/image/goods1.png',
      title: '新鲜梨花带雨',
      price: 0.01,
      stock: '有货',
      detail: '这里是梨花带雨详情。',
      parameter: '125g/个',
      service: '不支持退货'
    },
    num: 1,
    totalNum: 0,
    hasCarts: false,
    curIndex: 0,
    show: false,
    scaleCart: false
  },

  addCount() {
    let num = this.data.num;
    num++;
    this.setData({
      num : num
    })
  },

  addToCart() {
    const self = this;
    const num = this.data.num;
    let total = this.data.totalNum;

    self.setData({
      show: true
    })
    setTimeout( function() {
      self.setData({
        show: false,
        scaleCart : true
      })
      setTimeout( function() {
        self.setData({
          scaleCart: false,
          hasCarts : true,
          totalNum: num + total
        })
      }, 200)
    }, 300)
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/gwc',
      data: {
        num: self.data.num,
        id: self.data.goods.id,
        uid: app.globalData.user.id
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        if (res.data==1) {
          wx.showToast({
            title: '添加成功',
            icon: 'success',
            duration: 2000
          })
        }else{
           wx.showToast({
            title: '添加失败',
            icon: 'none',
            duration: 2000
          })
        }
        
      }
    })
  },

  bindTap(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
  },
  onLoad: function (options) {
    var self = this;
    console.log(options)
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/detail',
      data: {
        id: options.id
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        console.log(res);
        self.setData({
          goods:res.data
        })
      }
    })
  },
 
})