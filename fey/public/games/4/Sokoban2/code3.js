gdjs.loseCode = {};
gdjs.loseCode.localVariables = [];
gdjs.loseCode.GDBgObjects1= [];
gdjs.loseCode.GDBgObjects2= [];
gdjs.loseCode.GDLoseObjects1= [];
gdjs.loseCode.GDLoseObjects2= [];
gdjs.loseCode.GDPlayButtonObjects1= [];
gdjs.loseCode.GDPlayButtonObjects2= [];


gdjs.loseCode.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("PlayButton"), gdjs.loseCode.GDPlayButtonObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.loseCode.GDPlayButtonObjects1.length;i<l;++i) {
    if ( gdjs.loseCode.GDPlayButtonObjects1[i].getBehavior("ButtonFSM").IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.loseCode.GDPlayButtonObjects1[k] = gdjs.loseCode.GDPlayButtonObjects1[i];
        ++k;
    }
}
gdjs.loseCode.GDPlayButtonObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "FullSokobanGame", false);
}}

}


};

gdjs.loseCode.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.loseCode.GDBgObjects1.length = 0;
gdjs.loseCode.GDBgObjects2.length = 0;
gdjs.loseCode.GDLoseObjects1.length = 0;
gdjs.loseCode.GDLoseObjects2.length = 0;
gdjs.loseCode.GDPlayButtonObjects1.length = 0;
gdjs.loseCode.GDPlayButtonObjects2.length = 0;

gdjs.loseCode.eventsList0(runtimeScene);
gdjs.loseCode.GDBgObjects1.length = 0;
gdjs.loseCode.GDBgObjects2.length = 0;
gdjs.loseCode.GDLoseObjects1.length = 0;
gdjs.loseCode.GDLoseObjects2.length = 0;
gdjs.loseCode.GDPlayButtonObjects1.length = 0;
gdjs.loseCode.GDPlayButtonObjects2.length = 0;


return;

}

gdjs['loseCode'] = gdjs.loseCode;
