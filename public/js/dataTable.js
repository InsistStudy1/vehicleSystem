$(function () {
    //2017年事故每月发生数统计
    let accidentsNumber = echarts.init(document.getElementById('accidentsNumber'),'light');
    option = {
        title: {
            text: '2017年事故每月发生数统计'
        },
        tooltip: {
            trigger:'axis' //鼠标放上有水平线
        },
        legend: {
        },
        xAxis: {
            data: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
        },
        toolbox: {
            show: true,
            feature: {
                mark: false
            }
        },
        yAxis: {
            type: 'value',
            splitArea: { show: true }
        },
        series: [{
            name: '事故',
            type: 'bar',
            data: []
        }]
    };
    window.onresize = accidentsNumber.resize;
    $.ajax({
        type: "post",
        url: "../../index.php?p=Admin&c=data&a=AccidentInfo",
        data: {},
        dataType: "json",
        success: function (data) {
            var numberArr = [];
            for (let i = 0; i < data.length; i++) {
                numberArr.push(data[i].number);
            }
            option.series[0].data = numberArr;
            accidentsNumber.setOption(option);
        }
    })


    //2017年事故每月发生地点
    let accidentsAddress = echarts.init(document.getElementById('accidentsAddress'),'light');
    option1 = {
        backgroundColor: '#2c343c',

        title: {
            text: '2017年事故发生地点',
            left: 'center',
            top: 20,
            textStyle: {
                color: '#ccc'
            }
        },
        legend: {
            data:['城市']
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        visualMap: {
            show: false,
            min: 80,
            max: 600,
            inRange: {
                colorLightness: [0, 1]
            }
        },
        series : [
            {
                name:'事故地点',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                data:[],
                roseType: 'radius',
                label: {
                    normal: {
                        textStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        },
                        smooth: 0.2,
                        length: 10,
                        length2: 20
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#c23531',
                        shadowBlur: 200,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                },

                animationType: 'scale',
                animationEasing: 'elasticOut',
                animationDelay: function (idx) {
                    return Math.random() * 200;
                }
            }
        ]
    };
    window.onresize = accidentsAddress.resize;
    $.ajax({
        type: "post",
        url: "../../index.php?p=Admin&c=data&a=address",
        data: {},
        dataType: "json",
        success: function (data) {
                option1.series[0].data = data.sort(function (a, b) { return a.value - b.value; });
            accidentsAddress.setOption(option1);
        }
    })

    //5月份每日事故发生次数
    let acdMouthNumber = echarts.init(document.getElementById('acdMouthNumber'));
    option2 = {
        title: {
            text: '5月份每日事故发生次数'
        },
        xAxis: {
            type: 'category',
            data: ['1', '2', '3', '4', '5', '6', '7','8','9','10',
                '11', '12', '13', '14', '15', '16', '17','18','19','20',
                '21', '22', '23', '24', '25', '26', '27','28','29','30']
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [],
            type: 'line'
        }]
    };
    window.onresize = acdMouthNumber.resize;
    $.ajax({
        type: "post",
        url: "../data/acdMouthNumber.json",
        data: {},
        dataType: "json",
        success: function (data) {
            var numberArr = [];
            for (var i = 0; i < data.length; i++) {
                numberArr.push(data[i].data);
            }
            option2.series[0].data = numberArr;
            acdMouthNumber.setOption(option2);
        }
    })


    let mtPrice = echarts.init(document.getElementById('mtPrice'));
    option3 = {
        title: {
            text: '汽车事故维修价格范围',
            left: 'center',
            top: 0,
            textStyle: {
                color: '#000'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data:['1k以下','1k-3k','3k-5k','5k-1w','1w以上']
        },
        series: [
            {
                name:'维修价格',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[]
            }
        ]
    };
    window.onresize = mtPrice.resize;
    $.ajax({
        type: "post",
        url: "../../index.php?p=Admin&c=data&a=Price",
        data: {},
        dataType: "json",
        success: function (data) {
            option3.series[0].data = data;
            mtPrice.setOption(option3);
        }
    })
})
