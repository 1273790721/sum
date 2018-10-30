
var demo = angular.module("demo", ["RongWebIMWidget"]);
demo.config(function($logProvider){
  // $logProvider.debugEnabled(false);
})
demo.controller("main", ["$scope","WebIMWidget", "$http", function($scope,WebIMWidget,
  $http) {
  

  $scope.show = function() {
    WebIMWidget.show();
    
  }

  $scope.hidden = function() {
    WebIMWidget.hidden();
  }

  $scope.server = WebIMWidget;
  

  $scope.setconversation=function(id,name,targetType){
	$scope.targetType=targetType;
    WebIMWidget.setConversation(Number($scope.targetType), id, name);    
  }
  
  $scope.removeConversation=function(targetType,targetId){
	  $scope.targetType=targetType;
	  WebIMWidget.removeConversation(Number($scope.targetType), targetId);
  };
  
  var token = $('#token').val();

    WebIMWidget.init({
      appkey: "z3v5yqkbzc2l0",
      token: token,
      style:{
        width:600,
        positionFixed:true,
        bottom:20,
      },
      displayConversationList:true,
      conversationListPosition:WebIMWidget.EnumConversationListPosition.right,
      hiddenConversations:[{type:WebIMWidget.EnumConversationType.PRIVATE,id:'bb'}],
      onSuccess:function(id){
        console.log(id);
      },
      onError:function(error){
        console.log("error:"+error);
      }
    });

    WebIMWidget.show();

    WebIMWidget.setUserInfoProvider(function(targetId,obj){
        $http({
          url:"../Studentspace/userinfo"
        }).success(function(rep){
          var user;
          rep.forEach(function(item){
            if(item.id==targetId){           	
              user=item;
            }
          })

          if(user){
            obj.onSuccess({id:user.id,name:user.name,portraitUri:user.portraitUri});
          }else{
            obj.onSuccess({id:targetId,name:"陌："+targetId});
          }
        })
    });
    
    WebIMWidget.setGroupInfoProvider(function(targetId,obj){
        $http({
          url:"../Studentspace/groupinfo"
        }).success(function(rep){        	
          var group;
          rep.forEach(function(item){
            if(item.id==targetId){
            	group=item;
            }
          })
          if(group){
            obj.onSuccess({id:group.id,name:group.name,portraitUri:group.portraitUri});
          }else{
            obj.onSuccess({id:targetId,name:"陌："+targetId});
          }
        })
    });
    

    /*WebIMWidget.setOnlineStatusProvider(function(arr,obj){
        $http({
          url:"/online.json"
        }).success(function(rep){
          obj.onSuccess(rep.data);
        })
    })*/


    WebIMWidget.onClose=function(){
      console.log("已关闭");
    }

    WebIMWidget.show();
    
//  //getHistoryMessages
//    RongIMClient.getInstance().getHistoryMessages(RongIMLib.ConversationType.PRIVATE, 2, null, 20, {
//     onSuccess: function(list, hasMsg) {
//       // hasMsg为boolean值，如果为true则表示还有剩余历史消息可拉取，为false的话表示没有剩余历史消息可供拉取。
//          // list 为拉取到的历史消息列表
//    	 //alert(list)
//     },
//     onError: function(error) {
//         // APP未开启消息漫游或处理异常
//              // throw new ERROR ......
//     }
//   });


}]);

