// page/component/yuyuedd/yuyuedd.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },
  formSubmit(e){
    const value = e.detail.value;
    var that = this;
    if (value.yyname && value.tel){
      wx.request({
        url: 'http://localhost/diancan/public/index.php/api/index/yuyuedd',
        data: {
          yyname:value.yyname,
          tel:value.tel,
          canzhuo_id:that.data.id
        },
        method:'post',
        header: {
          'content-type': 'application/json' // 默认值
        },
        success (res) {
          wx.showToast({
            title: res.data,
            icon: 'none',
            duration: 2000
          })
          setTimeout(function() {
            wx.switchTab({
              url: '../yuyue/yuyue',
            })
          }, 2000);
          
        }
      })
    }else{
      wx.showModal({
        title:'提示',
        content:'你有信息未填写',
        showCancel:false
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    this.setData({
      id:id
    })
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