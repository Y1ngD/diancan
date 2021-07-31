// page/component/login.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },
  formSubmit(e){
    const value = e.detail.value;
    var that = this;
    if (value.username && value.password){
      wx.request({
        url: 'http://localhost/diancan/public/index.php/api/index/login',
        data: {
          username:value.username,
          password:value.password
        },
        method:'post',
        header: {
          'content-type': 'application/json' // 默认值
        },
        success (res) {
          if(res.data.msg==1){
            app.globalData.user = res.data.user; 
            wx.switchTab({
              url:'index'
            });
          }else{
            wx.showToast({
              title: '账号或密码错误',
              icon: 'none',
              duration: 2000
            })
          }
        }
      })
    }else{
      wx.showModal({
        title:'提示',
        content:'未填写账号或密码',
        showCancel:false
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