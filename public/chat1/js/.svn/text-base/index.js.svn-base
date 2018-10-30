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
  
  var targetType = $('#targetType').val();
  $scope.setconversation=function(){
  var id = $('#targetId').val();
  var name = $('#targetIds').val();
  $scope.targetType=targetType;
  if(id){
      WebIMWidget.setConversation(Number($scope.targetType),id,name);
  }
  }
  
  $scope.removeConversation=function(targetType,targetId){
    $scope.targetType=targetType;
    WebIMWidget.removeConversation(Number($scope.targetType), targetId);
  };
  
  var token = $('#token').val();
    WebIMWidget.init({
      appkey: "z3v5yqkbzcc80",
      token: token,
      style:{
//    right:300,
//    bottom:200,
      width:600,
      height:440
      },
      displayConversationList:true,
      conversationListPosition:WebIMWidget.EnumConversationListPosition.right,
      hiddenConversations:[{type:WebIMWidget.EnumConversationType.SYSTEM,id:'system'}],
      onSuccess:function(id){
        $scope.user = id;
       //   document.title = '用户：' + id;
        console.log('连接成功：' + id);
      
     /* var noe_id = $(".noe_ids").val();
      if(noe_id){
      getDealer(noe_id);
       $("#noe_id").attr("class", ""); 
      }*/
      },
      onError:function(error){
        console.log("error:"+error);
      }
    });

    WebIMWidget.show();

    WebIMWidget.setUserInfoProvider(function(targetId,obj){
        $http({ 
          url:"../chat/rongyun"
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
            obj.onSuccess({id:targetId,name:"用户："+targetId});
          }
        })
    
    });

    WebIMWidget.onClose=function(){
      console.log("已关闭");
    }

    WebIMWidget.show();


}]);

