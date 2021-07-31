// page/component/zhuce/zhuce.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },
  formSubmit(e) {
    var password = e.detail.value.password;
    var username = e.detail.value.username;
    var repassword = e.detail.value.repassword;
    if (password != repassword) {
      wx.showToast({
        title: '两次输入的密码不一致',
        icon: 'none',
        duration: 2000
      })
    } else {
      wx.request({
        url: 'http://localhost/diancan/public/index.php/api/index/zhuce',
        data: {
          username:username,
          password:password
        },
        method:'post',
        header: {
          'content-type': 'application/json' // 默认值
        },
        success (res) {
          if(res.data==1){
            wx.showToast({
              title: '注册成功',
              icon: 'success',
              duration: 2000
            })
          }else{
            wx.showToast({
              title: '账号已注册',
              icon: 'none',
              duration: 2000
            })
          }
        }
      })
    }
    
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})