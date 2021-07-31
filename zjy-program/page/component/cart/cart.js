// page/component/new-pages/cart/cart.js
const app = getApp()
Page({
  data: {
    carts:[],               // 购物车列表
    hasList:false,          // 列表是否有数据
    totalPrice:0,           // 总价，初始为0
    selectAllStatus:true,    // 全选状态，默认全选
    obj:{
        name:"hello"
    }
  },
  onShow() {
    var that = this;
    var id = app.globalData.user.id;
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/gwcList',
      data: {
        id : id
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        console.log(res);
        that.setData({
          hasList: true,
          carts: res.data
        })
        that.getTotalPrice();
      }
    })
    
  },
  /**
   * 当前商品选中事件
   */
  selectList(e) {
    const index = e.currentTarget.dataset.index;
    let carts = this.data.carts;
    const selected = carts[index].selected;
    carts[index].selected = !selected;
    this.setData({
      carts: carts
    });
    this.getTotalPrice();
  },

  /**
   * 删除购物车当前商品
   */
  deleteList(e) {
    const index = e.currentTarget.dataset.index;
    let carts = this.data.carts;
    carts.splice(index,1);
    this.setData({
      carts: carts
    });
    if(!carts.length){
      this.setData({
        hasList: false
      });
    }else{
      this.getTotalPrice();
    }
    var that = this;
    var id = e.currentTarget.dataset.id;
    wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/gwcDel',
      data: {
        id : id
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        console.log(res);
        if (res.data==1) {
          wx.showToast({
            title: '删除成功',
            icon: 'success',
            duration: 2000
          })
        }else{
          wx.showToast({
            title: '删除失败',
            icon: 'none',
            duration: 2000
          })
        }
      }
    })
  },

  /**
   * 购物车全选事件
   */
  selectAll(e) {
    let selectAllStatus = this.data.selectAllStatus;
    selectAllStatus = !selectAllStatus;
    let carts = this.data.carts;

    for (let i = 0; i < carts.length; i++) {
      carts[i].selected = selectAllStatus;
    }
    this.setData({
      selectAllStatus: selectAllStatus,
      carts: carts
    });
    this.getTotalPrice();
  },

  /**
   * 绑定加数量事件
   */
  addCount(e) {
    const index = e.currentTarget.dataset.index;
    let carts = this.data.carts;
    let num = carts[index].num;
    num = num + 1;
    carts[index].num = num;
    this.setData({
      carts: carts
    });
    this.getTotalPrice();
  },

  /**
   * 绑定减数量事件
   */
  minusCount(e) {
    const index = e.currentTarget.dataset.index;
    const obj = e.currentTarget.dataset.obj;
    let carts = this.data.carts;
    let num = carts[index].num;
    if(num <= 1){
      return false;
    }
    num = num - 1;
    carts[index].num = num;
    this.setData({
      carts: carts
    });
    this.getTotalPrice();
  },

  /**
   * 计算总价
   */
  getTotalPrice() {
    let carts = this.data.carts;                  // 获取购物车列表
    let total = 0;
    for(let i = 0; i<carts.length; i++) {         // 循环列表得到每个数据
      if(carts[i].selected) {                     // 判断选中才会计算价格
        total += carts[i].num * carts[i].price;   // 所有价格加起来
      }
    }
    this.setData({                                // 最后赋值到data中渲染到页面
      carts: carts,
      totalPrice: total.toFixed(2)
    });
  },
  js:function() {
    var that = this;
    var uid = app.globalData.user.id;
     wx.request({
      url: 'http://localhost/diancan/public/index.php/api/index/js',
      data: {
        carts : that.data.carts,
        totalPrice : that.data.totalPrice,
        uid : uid
      },
      method:'post',
      header: {
        'content-type': 'application/json' // 默认值
      },
      success (res) {
        console.log(res);
        if (res.data==1) {
          wx.showToast({
            title: '结算成功',
            icon: 'success',
            duration: 2000
          })
          that.onShow();
        }else{
          wx.showToast({
            title: '结算失败',
            icon: 'none',
            duration: 2000
          })
        }
      }
    })
  }
})