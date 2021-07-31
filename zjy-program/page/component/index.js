Page({
  data: {
    imgUrls: [
      '/image/b1.jpg',
      '/image/b2.jpg',
      '/image/b3.jpg'
    ],
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
  },
  tz:function(){
    wx.switchTab({
      url: 'category/category',
    })
  },
  onLoad: function (options) {
    var that = this;
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/shop',
      data: {
        
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        console.log(res);
        that.setData({
          list: res.data
        })
      }
    })
  }
})
