let timeId = null;
Page({
    data: {
        history: [],
        hot: ['榴莲班戟', '雪山杨枝甘露', '西贡双皮奶'],
        result: [
            {
                id: 1,
                url: '../details/details',
                thumb: '/image/s4.png',
                title: '黄焖鸡米饭 500g',
                price: 15
                
            },
            
            // {
            //     id: 2,
            //     url: '../details/details',
            //     thumb: '/image/s5.png',
            //     title: '新鲜芹菜 500g',
            //     price: 0.02
            // }
        ],
        showKeywords: false,
        keywords: ['黄焖鸡', '', '', ''],
        value: '',
        showResult: false,
    },
    cancelSearch() {
        this.setData({
            showResult: false,
            showKeywords: false,
            value: ''
        })
    },
    searchInput(e) {
        if(!e.detail.value){
            this.setData({
                showKeywords: false
            })
        }else{
            if(!this.data.showKeywords){
                timeId && clearTimeout(timeId);
                timeId = setTimeout(() => {
                    this.setData({
                        showKeywords: true
                    })
                }, 1000)
            }
        }
    },
    keywordHandle(e) {
        const text = e.target.dataset.text;
        this.setData({
            value: text,
            showKeywords: false,
            showResult: true
        })
        this.historyHandle(text);
    },
    historyHandle(value) {
        let history = this.data.history;
        const idx = history.indexOf(value);
        if (idx === -1) {
            // 搜索记录只保留8个
            if (history.length > 7) {
                history.pop();
            }
        } else {
            history.splice(idx, 1);
        }
        history.unshift(value);
        wx.setStorageSync('history', JSON.stringify(history));
        this.setData({
            history
        });
    },
    onLoad() {
        const history = wx.getStorageSync('history');
        if (history) {
            this.setData({
                history: JSON.parse(history)
            })
            console.log(this.data.history);
        }
    }
})