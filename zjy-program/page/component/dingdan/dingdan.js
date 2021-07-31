// page/component/new-pages/user/user.js
const app = getApp()
Page({
  data:{
    thumb:'',
    nickname:'',
    orders:[],
    hasAddress:false,
    address:{}
  },
  onLoad(){
    var self = this;
    /**
     * 获取用户信息
     */
    wx.getUserInfo({
      success: function(res){
        self.setData({
          thumb: res.userInfo.avatarUrl,
          nickname: res.userInfo.nickName
        })
      }
      
    })
  },
  onShow(){
    var self = this;
    var id = app.globalData.user.id;
    /**
     * 发起请求获取订单列表信息
     */
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/order',
      method:'post',
      data: {
        id : app.globalData.user.id
      },
      success(res){
        console.log(res);
        self.setData({
          orders: res.data
        })
      }
    })
  },
  /**
   * 发起支付请求
   */
  payOrders(){
    wx.requestPayment({
      timeStamp: 'String1',
      nonceStr: 'String2',
      package: 'String3',
      signType: 'MD5',
      paySign: 'String4',
      success: function(res){
        console.log(res)
      },
      fail: function(res) {
        wx.showModal({
          title:'支付提示',
          content:'<text>',
          showCancel: false
        })
      }
    })
  }
})