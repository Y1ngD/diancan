Page({
    data: {
        category: [
            {name:'果味',id:'guowei'},
            {name:'蔬菜',id:'shucai'},
            {name:'炒货',id:'chaohuo'},
            {name:'点心',id:'dianxin'},
            {name:'粗茶',id:'cucha'},
            {name:'淡饭',id:'danfan'}
        ],
        detail:[],
        curIndex: 0,
        isScroll: false,
        toView: 'guowei'
    },
    onReady(){
        var self = this;
        wx.request({
            url:'http://localhost/diancan/public/index.php/api/index/type',
            success(res){
              console.log(res.data)
                self.setData({
                    detail : res.data.detail,
                    category : res.data.type
                })
            }
        });
        
    },
    tz(e){
      console.log(e);
      var id = e.currentTarget.dataset.id
      wx.navigateTo({
        url: '../details/details?id='+id,
      })
    },
    switchTab(e){
      const self = this;
      this.setData({
        isScroll: true
      })
      setTimeout(function(){
        self.setData({
          toView: e.target.dataset.id,
          curIndex: e.target.dataset.index
        })
      },0)
      setTimeout(function () {
        self.setData({
          isScroll: false
        })
      },1)
      wx.request({
        url:'http://localhost/diancan/public/index.php/api/index/type',
        data:{
          id:e.target.dataset.id
        },
        success(res){
            self.setData({
                detail : res.data.detail,
                category : res.data.type
            })
        }
      }); 
    }
    
})