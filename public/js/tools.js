/**
 * Created by Machenike on 2018/5/18.
 */

(function () {
    /*
     * construction { Verification } 验证各类正则表达式
     * */
    function Verification() {
    }

    //给原型添加成员
    Verification.prototype = {
        constructor: Verification,

        //判断是否为空
        checkIsNull: function (array) {
            var flag = true;
            array.forEach(function (str) {
                if (str == '') {
                    flag = false;
                    return false;
                }
            });
            if (flag) return true;
            return false;
        },

        //判断车牌号码
        checkCarNumber: function (vehicleNumber) {
            var xreg = /^[A-Z]{1}(([0-9]{5}[DF]$)|([DF][A-HJ-NP-Z0-9][0-9]{4}$))/,
                creg = /^[A-Z]{1}[A-HJ-NP-Z0-9]{4}[A-HJ-NP-Z0-9挂学警港澳]{1}$/;
            if (vehicleNumber.length == 6) {
                return creg.test(vehicleNumber);
            } else if (vehicleNumber.length == 5) {
                return xreg.test(vehicleNumber);
            } else {
                return false;
            }
        },

        //身份证号码验证
        checkIdCard: function (number) {
            // 身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X
            var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
            if (reg.test(number)) return true;
            return false;
        },

        //手机号码验证
        checkTel: function (Tel) {
            var myreg = /^1[3|4|5|7|8][0-9]{9}$/;
            if (myreg.test(Tel)) return true;
            return false;
        }
    }

    /*
     * constructor { OperateInfo } 增删改信息对象
     * */
    function OperateInfo() {
    }

    OperateInfo.prototype = {
        /*
         * getDate：获取数据
         * param { url: URL } 发送AJAX路径
         * param { data: Object } 传入的数据对象
         * */
        getData: function (url, data, info, callback) {
            var mySelf = this;
            $.ajax({
                url: url,
                type: "post",
                data: data,
                dataType: "json",
                success: function (data) {
                    //数据对象
                    var dataObj = {
                        info: data.data
                    };
                    //当前页
                    var current = data.current;
                    //总页数
                    var totle = data.total;
                    var resStr = template('template', dataObj);
                    //把内容存进表格
                    $('#datatable tbody').html(resStr);

                    //根据totlePage添加页码
                    $('.number-box').html("");

                    //最小页码数
                    var minPage = current;

                    //最大页码数
                    var maxPage = current + 4 > totle ? maxPage = totle : current + 4;

                    minPage = maxPage - 4 < 1 ? minPage = 1 : maxPage - 4;

                    for (var i = minPage; i <= maxPage; i++) {
                        var newI = $("<i>" + i + "</i>");
                        newI.removeClass('active');
                        if (i == current) {
                            newI.addClass('active');
                        }
                        $('.number-box').append(newI);
                    }
                    //显示总页数
                    $('#totlePage').text(totle);

                    if(callback){
                        callback(current,totle);
                    }

                    var updateBtn = $('.updateInfo'),
                        delBtn = $('.deleteInfo');

                    switch (info) {
                        case 'car':
                            updateBtn.on('click', mySelf.updateCarInfo);
                            delBtn.on('click', function () {
                                var self = $(this);
                                mySelf.deleteInfo(self, '../../index.php?p=Admin&c=CarInfo&a=delete', 'Cid');
                            });
                            break;
                        case 'driver':
                            updateBtn.on('click', mySelf.updateDriverInfo);
                            delBtn.on('click', function () {
                                var self = $(this);
                                mySelf.deleteInfo(self, '../../index.php?p=Admin&c=DriverInfo&a=delete', 'Sid');
                            });
                            break;
                        case 'maintain':
                            updateBtn.on('click', mySelf.updateMaintainInfo);
                            delBtn.on('click', function () {
                                var self = $(this);
                                mySelf.deleteInfo(self, '../../index.php?p=Admin&c=Maintainfo&a=delete', 'Wid');
                            });
                            break;
                        case 'accident':
                            updateBtn.on('click', mySelf.updateAccidentInfo);
                            delBtn.on('click', function () {
                                var self = $(this);
                                mySelf.deleteInfo(self, '../../index.php?p=Admin&c=AccidentInfo&a=delete', 'Gid');
                            });
                            break;
                    }

                }
            })
        },

        /*
         * 添加车辆信息
         * param { url: URL } 传输信息到的php页面
         * */
        carInfo: function (url) {
            // 新建正则工具
            var check = getVerification();

            var carFirtWord = $('#carArea').val(), //车牌省份代表字
                carIdVal = $('#carId').val(), //车牌号
                FidVal = $('#Fid').val(), //发动机编号
                ChjVal = $('#Chj').val(), //生产厂家
                ChrqVal = $('#Chrq').val(), //生产日期
                ZzhVal = $('#Zzh').val(), //载重
                zwVal = $('#zw').val(), //座位数
                dataArray = [carFirtWord, carIdVal, FidVal, ChjVal, ChrqVal, ZzhVal, zwVal];

            if (check.checkIsNull(dataArray)) {
                if (check.checkCarNumber(carIdVal)) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            'Cid': carFirtWord + carIdVal,
                            'Fid': FidVal,
                            'Chj': ChjVal,
                            'Chrq': ChrqVal,
                            'Zzh': ZzhVal,
                            'zw': zwVal
                        },
                        success: function (data) {
                            promptInfo(data, '添加');
                        }
                    })
                } else {
                    popup({type: 'error', msg: "车牌号格式不正确", delay: 1500, bg: true, clickDomCancel: true});
                }

            } else {
                popup({type: 'error', msg: "信息填写不完整", delay: 1500, bg: true, clickDomCancel: true});
            }
        },

        // 添加司机信息
        driverInfo: function (url) {
            // 新建正则工具
            var check = getVerification();

            var sidVal = $('#Sid').val(),//司机编号
                carFirtWord = $('#carArea').val(),//车牌省份代表字
                carIdVal = $('#carId').val(),//车牌号
                snameVal = $('#Sname').val(),//司机姓名
                sexVal = $("input[name='sex']:checked").val(),//性别
                sfidVal = $('#Sfid').val(),//身份证号码
                phoneVal = $('#Phone').val(),//电话
                saddressVal = $('#province').val() + $('#city').val() + $('#district').val(),//地址
                dataArr = [sidVal, carFirtWord, carIdVal, snameVal, sexVal, sfidVal, phoneVal, saddressVal];

            if (check.checkIsNull(dataArr)) {
                if (!check.checkCarNumber(carIdVal)) {
                    popup({type: 'error', msg: "车牌号格式不正确", delay: 1500, bg: true, clickDomCancel: true});return;
                }
                if(!check.checkIdCard(sfidVal)) {
                    popup({type: 'error', msg: "身份证格式不正确", delay: 1500, bg: true, clickDomCancel: true});return;
                }
                if(!check.checkTel(phoneVal)) {
                    popup({type: 'error', msg: "手机号格式不正确", delay: 1500, bg: true, clickDomCancel: true});return;
                }
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        'Sid': sidVal,
                        'Cid': carFirtWord + carIdVal,
                        'Sname': snameVal,
                        'Sex': sexVal,
                        'Sfid': sfidVal,
                        'Phone': phoneVal,
                        'Saddress': saddressVal
                    },
                    success: function (data) {
                        promptInfo(data,'添加');
                    }
                })
            } else {
                popup({type: 'error', msg: "信息添加不完整", delay: 1500, bg: true, clickDomCancel: true});
            }
        },

        // 添加维修信息
        maintainfo: function (url) {
            // 新建正则工具
            var check = getVerification();

            var widVal = $('#Wid').val(),//维修编号
                carFirtWord = $('#carArea').val(),//车牌省份代表字
                carIdVal = $('#carId').val(),//车牌号
                nrVal = $('#Nr').val(),//维修内容
                fyVal = $('#Fy').val(),//维修费用
                wrqVal = $('#Wrq').val(),//维修日期
                waddressVal = $('#Waddress').val(),//维修地址
                dataArr = [widVal, carFirtWord, carIdVal, nrVal, fyVal, wrqVal, waddressVal];

            if (check.checkIsNull(dataArr)) {
                if (!check.checkCarNumber(carIdVal)) {
                    popup({type: 'error', msg: "车牌号格式不正确", delay: 1500, bg: true, clickDomCancel: true});return;
                }
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        'Wid': widVal,
                        'Cid': carFirtWord + carIdVal,
                        'Nr': nrVal,
                        'Fy': fyVal,
                        'Wrq': wrqVal,
                        'Waddress': waddressVal
                    },
                    success: function (data) {
                        promptInfo(data,'添加');
                    }
                })
            } else {
                popup({type: 'error', msg: "信息添加不完整", delay: 1500, bg: true, clickDomCancel: true});
            }
        },

        // 添加事故信息
        accidentInfo: function (url) {
            // 新建正则工具
            var check = getVerification();

            var gidVal = $('#Gid').val(),//事故编号
                carFirtWord = $('#carArea').val(), //车牌省份代表字
                carIdVal = $('#carId').val(), //车牌号
                sidVal = $('#Sid').val(),//司机编号
                grqVal = $('#Grq').val(),//事故日期
                gaddressVal = $('#Gaddress').val(),//事故地点
                yyVal = $('#Yy').val(),//事故原因
                jeVal = $('#Je').val(),//事故原因
                dataArr = [gidVal, carFirtWord, carIdVal, sidVal];
            if (check.checkIsNull(dataArr)) {
                if (!check.checkCarNumber(carIdVal)) {
                    popup({type: 'error', msg: "车牌号格式不正确", delay: 1500, bg: true, clickDomCancel: true});return;
                }
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        'Gid': gidVal,
                        'Cid': carFirtWord + carIdVal,
                        'Sid': sidVal,
                        'Grq': grqVal,
                        'Gaddress': gaddressVal,
                        'Yy': yyVal,
                        'Je': jeVal
                    },
                    success: function (data) {
                        promptInfo(data,'添加');
                    }
                })
            } else {
                popup({type: 'error', msg: "信息添加不完整", delay: 1500, bg: true, clickDomCancel: true});
            }
        },

        /*
         * deleteInfo：删除本条记录
         * param { self: Object } 按钮
         * param { url: URL } 发送AJAX路径
         * param { primaryKey: string } 根据这个主键删除
         * */
        deleteInfo: function (self, url, primaryKey) {
            var tr = self.parent().parent(),
                id = self.parent().siblings().eq(0).text(),
                data = {};
            data[primaryKey] = id;
            $('#deleteModal').modal('show');
            $('#deleteInfo').on('click', function () {
                $.ajax({
                    url: url,
                    type: "get",
                    data: data,
                    success: function (data) {
                        $('#deleteModal').modal('hide');
                        promptInfo(data, '删除', function () {
                            tr.remove();
                        });
                    },
                    error: function () {
                        popup({type: 'error', msg: "添加失败", delay: 1500, bg: true, clickDomCancel: true});
                    }
                })
            })
        },

        //修改车辆信息
        updateCarInfo: function () {
            // 新建正则工具
            var check = getVerification(),

                tds = $(this).parent().siblings(),
                Cid = tds.eq(0).text();

            $('#carArea').val(Cid.substr(0, 1));
            $('#carId').val(Cid.substr(1));
            $('#Fid').val(tds.eq(1).text());
            $('#Chj').val(tds.eq(2).text());
            $('#Chrq').val(tds.eq(3).text());
            $('#Zzh').val(tds.eq(4).text());
            $('#zw').val(tds.eq(5).text());


            $('#updateModal').modal('show');
            $('#updateCarInfo').on('click', function () {
                var carFirtWord = $('#carArea').val(),
                    carIdVal = $('#carId').val(),
                    FidVal = $('#Fid').val(),
                    ChjVal = $('#Chj').val(),
                    ChrqVal = $('#Chrq').val(),
                    ZzhVal = $('#Zzh').val(),
                    zwVal = $('#zw').val();
                if (check.checkIsNull([carIdVal])) {
                    if (check.checkCarNumber(carIdVal)) {
                        $('#carId').removeClass('warm');
                        $.ajax({
                            url: '../../index.php?p=Admin&c=CarInfo&a=update',
                            type: "post",
                            data: {
                                'Cid': carFirtWord + carIdVal,
                                'Fid': FidVal,
                                'Chj': ChjVal,
                                'Chrq': ChrqVal,
                                'Zzh': ZzhVal,
                                'zw': zwVal
                            },
                            success: function (data) {
                                promptInfo(data, '修改', function () {
                                    $('#updateModal').modal('hide');
                                    tds.eq(0).text(carFirtWord + carIdVal);
                                    tds.eq(1).text(FidVal);
                                    tds.eq(2).text(ChjVal);
                                    tds.eq(3).text(ChrqVal);
                                    tds.eq(4).text(ZzhVal);
                                    tds.eq(5).text(zwVal);
                                });
                            },
                            error: function () {
                                popup({type: 'error', msg: "添加失败", delay: 1500, bg: true, clickDomCancel: true});
                            }
                        })
                    } else {
                        $('#carId').addClass('warm');
                    }
                } else {
                    $('#carId').addClass('warm');
                }
            })
        },

        //修改司机信息
        updateDriverInfo: function () {
            // 新建正则工具
            var check = getVerification(),

                tds = $(this).parent().siblings(),
                Cid = tds.eq(1).text();

            $('#Sid').val(tds.eq(0).text());
            $('#carArea').val(Cid.substr(0, 1));
            $('#carId').val(Cid.substr(1));
            $('#Sname').val(tds.eq(2).text());
            $('#Sfid').val(tds.eq(4).text());
            $('#Phone').val(tds.eq(5).text());
            $('#Saddress').val(tds.eq(6).text());
            if (tds.eq(3).text() == '男') {
                $(':radio[name="sex"][value="男"]').attr("checked", "checked")
            } else {
                $(':radio[name="sex"][value="女"]').attr("checked", "checked")
            }


            $('#updateModal').modal('show');
            $('#updateCarInfo').on('click', function () {
                var Sid = $('#Sid').val(),
                    carFirtWord = $('#carArea').val(),
                    carIdVal = $('#carId').val(),
                    Sname = $('#Sname').val(),
                    Sex = $("input[name='sex']:checked").val(),
                    Sfid = $('#Sfid').val(),
                    Phone = $('#Phone').val(),
                    Saddress = $('#Saddress').val();
                if (!check.checkIsNull([Sid])) {
                    $('#Sid').addClass('warm');
                    return;
                }
                $.ajax({
                    url: '../../index.php?p=Admin&c=DriverInfo&a=update',
                    type: "post",
                    data: {
                        'Sid': Sid,
                        'Cid': carFirtWord + carIdVal,
                        'Sname': Sname,
                        'Sex': Sex,
                        'Sfid': Sfid,
                        'Phone': Phone,
                        'Saddress': Saddress
                    },
                    success: function (data) {
                        $('#carId').removeClass('warm');
                        promptInfo(data, '修改', function () {
                            $('#updateModal').modal('hide');
                            tds.eq(0).text(Sid);
                            tds.eq(1).text(carFirtWord + carIdVal);
                            tds.eq(2).text(Sname);
                            tds.eq(3).text(Sex);
                            tds.eq(4).text(Sfid);
                            tds.eq(5).text(Phone);
                            tds.eq(6).text(Saddress);
                        });
                    },
                    error: function () {
                        popup({type: 'error', msg: "添加失败", delay: 1500, bg: true, clickDomCancel: true});
                    }
                })
            })
        },

        //修改维修信息
        updateMaintainInfo: function () {
            // 新建正则工具
            var check = getVerification();

            var tds = $(this).parent().siblings();
            var Cid = tds.eq(1).text();

            $('#Wid').val(tds.eq(0).text());
            $('#carArea').val(Cid.substr(0, 1));
            $('#carId').val(Cid.substr(1));
            $('#Nr').val(tds.eq(2).text());
            $('#Fy').val(tds.eq(3).text());
            $('#Wrq').val(tds.eq(4).text());
            $('#Waddress').val(tds.eq(5).text());

            $('#updateModal').modal('show');
            $('#updateCarInfo').on('click', function () {
                var Wid = $('#Wid').val(),
                    carFirtWord = $('#carArea').val(),
                    carIdVal = $('#carId').val(),
                    Nr = $('#Nr').val(),
                    Fy = $("#Fy").val(),
                    Wrq = $('#Wrq').val(),
                    Waddress = $('#Waddress').val();
                if (check.checkIsNull([Wid])) {
                    $.ajax({
                        url: '../../index.php?p=Admin&c=Maintainfo&a=update',
                        type: "post",
                        data: {
                            'Wid': Wid,
                            'Cid': carFirtWord + carIdVal,
                            'Nr': Nr,
                            'Fy': Fy,
                            'Wrq': Wrq,
                            'Waddress': Waddress
                        },
                        success: function (data) {
                            $('#Wid').removeClass('warm');
                            promptInfo(data, '修改', function () {
                                $('#updateModal').modal('hide');
                                tds.eq(0).text(Wid);
                                tds.eq(1).text(carFirtWord + carIdVal);
                                tds.eq(2).text(Nr);
                                tds.eq(3).text(Fy);
                                tds.eq(4).text(Wrq);
                                tds.eq(5).text(Waddress);
                            });
                        },
                        error: function () {
                            popup({type: 'error', msg: "添加失败", delay: 1500, bg: true, clickDomCancel: true});
                        }
                    })
                } else {
                    $('#Wid').addClass('warm');
                }
            })
        },

        //修改事故信息
        updateAccidentInfo: function () {
            // 新建正则工具
            var check = getVerification();

            var tds = $(this).parent().siblings();
            var Cid = tds.eq(1).text();

            $('#Gid').val(tds.eq(0).text());
            $('#carArea').val(Cid.substr(0, 1));
            $('#carId').val(Cid.substr(1));
            $('#Sid').val(tds.eq(2).text());
            $('#Grq').val(tds.eq(3).text());
            $('#Gaddress').val(tds.eq(4).text());
            $('#Yy').val(tds.eq(5).text());
            $('#Je').val(tds.eq(6).text());

            $('#updateModal').modal('show');
            $('#updateCarInfo').on('click', function () {
                var Gid = $('#Gid').val(),
                    carFirtWord = $('#carArea').val(),
                    carIdVal = $('#carId').val(),
                    Sid = $('#Sid').val(),
                    Grq = $("#Grq").val(),
                    Gaddress = $('#Gaddress').val(),
                    Yy = $('#Yy').val(),
                    Je = $('#Je').val();
                if (check.checkIsNull([Gid])) {
                    $.ajax({
                        url: '../../index.php?p=Admin&c=AccidentInfo&a=update',
                        type: "post",
                        data: {
                            'Gid': Gid,
                            'Cid': carFirtWord + carIdVal,
                            'Sid': Sid,
                            'Grq': Grq,
                            'Gaddress': Gaddress,
                            'Yy': Yy,
                            'Je': Je
                        },
                        success: function (data) {
                            $('#Gid').removeClass('warm');
                            promptInfo(data, '修改', function () {
                                $('#updateModal').modal('hide');
                                tds.eq(0).text(Gid);
                                tds.eq(1).text(carFirtWord + carIdVal);
                                tds.eq(2).text(Sid);
                                tds.eq(3).text(Grq);
                                tds.eq(4).text(Gaddress);
                                tds.eq(5).text(Yy);
                                tds.eq(6).text(Je);
                            });
                        },
                        error: function () {
                            popup({type: 'error', msg: "添加失败", delay: 1500, bg: true, clickDomCancel: true});
                        }
                    })
                } else {
                    $('#Gid').addClass('warm');
                }
            })
        }
    };

    /*
    * processData：数据处理工具
    * param {infoUrl：URL} 获取数据地址
    * param {selectInfoUrl：URL} 查询数据地址
    * param {infoUrl：URL} 数据类型
    * param {id：string} 查询数据发送的id
    * */
    function processData(infoUrl,selectInfoUrl,type,id){
        //新建操作对象工具
        var OperateInfo = getOperateInfo(),

        //初始化当前页数和总页数
            pageCurrent = 1,
            totlePage = 1;

        //初始化数据
        OperateInfo.getData(infoUrl,{"page": pageCurrent},type, function (current,totle) {
            pageCurrent = current;
            totlePage = totle;
        });

        //点击下一页
        $('#next').on('click', function () {
            if(pageCurrent == totlePage){
                popup({type: 'tip', msg: '当前是最后一页了', delay: 1000, bg: true, clickDomCancel: true});
                return;
            }
            pageCurrent++;
            OperateInfo.getData(infoUrl,{"page": pageCurrent},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })
        //点击上一页
        $('#prev').on('click', function () {
            if(pageCurrent == 1){
                popup({type: 'tip', msg: '当前是第一页了', delay: 1000, bg: true, clickDomCancel: true});
                return;
            }
            pageCurrent--;
            OperateInfo.getData(infoUrl,{"page": pageCurrent},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })
        //点击页码跳转
        $('.number-box').on('click', function (e) {
            //获取点击事件源
            var i = e.target || e.srcElement;
            OperateInfo.getData(infoUrl,{"page": i.innerText},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })
        //点击首页
        $('#firstPage').on('click', function () {
            OperateInfo.getData(infoUrl,{"page": 1},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })
        //点击尾页
        $('#lastPage').on('click', function () {
            OperateInfo.getData(infoUrl,{"page": totlePage},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })
        //点击跳转
        $('#jump').on('click', function () {
            var jumpPage = $('#jumpPage').val();
            if(jumpPage == undefined){return;}
            if(jumpPage<1 || jumpPage>totlePage){
                popup({type: 'tip', msg: '没有此页数据哦', delay: 1000, bg: true, clickDomCancel: true});return;
            }
            OperateInfo.getData(infoUrl,{"page": jumpPage},type, function (current,totle) {
                pageCurrent = current;
                totlePage = totle;
            });
        })

        //查询
        $('#search').on("keyup", function (e) {
            var event = e || window.event;
            //当按下回车时搜索
            if (event.which == 13) {
                var obj = {},
                    id1 = $('.selected').val();
                obj[id1] = $(this).val();
                obj['key'] = id;
                if($(this).val() == ""){
                    OperateInfo.getData(infoUrl,obj ,type);
                }else {
                    OperateInfo.getData(selectInfoUrl,obj,type, function (current,totle) {
                        pageCurrent = current;
                        totlePage = totle;
                    });
                }
            }
        })

    }

    //正则工具
    window.getVerification = function () {
        return new Verification();
    }
    //信息添加工具
    window.getOperateInfo = function () {
        return new OperateInfo();
    }

    /*
     * promptInfo: 信息提示工具
     * param { data: number } 后台返回值，通过该值判断是否成功
     * param { text: string } 提示信息文字
     * param { callback: Function } 执行成功时的回调函数
     * */
    window.promptInfo = function (data, text, callback) {
        if (data == 1) {
            if (callback) {
                callback();
            }
            popup({type: 'success', msg: text + "成功", delay: 1000});
        } else {
            popup({type: 'error', msg: text + "失败", delay: 1500, bg: true, clickDomCancel: true});
        }
    }

    window.processData = processData;
}(window));
