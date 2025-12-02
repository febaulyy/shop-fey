gdjs.loseCode = {};
gdjs.loseCode.localVariables = [];
gdjs.loseCode.GDpaObjects1= [];
gdjs.loseCode.GDpaObjects2= [];
gdjs.loseCode.GDpanelObjects1= [];
gdjs.loseCode.GDpanelObjects2= [];
gdjs.loseCode.GDloseObjects1= [];
gdjs.loseCode.GDloseObjects2= [];


gdjs.loseCode.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("pa"), gdjs.loseCode.GDpaObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.loseCode.GDpaObjects1.length;i<l;++i) {
    if ( gdjs.loseCode.GDpaObjects1[i].IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.loseCode.GDpaObjects1[k] = gdjs.loseCode.GDpaObjects1[i];
        ++k;
    }
}
gdjs.loseCode.GDpaObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "forest", false);
}}

}


};

gdjs.loseCode.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.loseCode.GDpaObjects1.length = 0;
gdjs.loseCode.GDpaObjects2.length = 0;
gdjs.loseCode.GDpanelObjects1.length = 0;
gdjs.loseCode.GDpanelObjects2.length = 0;
gdjs.loseCode.GDloseObjects1.length = 0;
gdjs.loseCode.GDloseObjects2.length = 0;

gdjs.loseCode.eventsList0(runtimeScene);
gdjs.loseCode.GDpaObjects1.length = 0;
gdjs.loseCode.GDpaObjects2.length = 0;
gdjs.loseCode.GDpanelObjects1.length = 0;
gdjs.loseCode.GDpanelObjects2.length = 0;
gdjs.loseCode.GDloseObjects1.length = 0;
gdjs.loseCode.GDloseObjects2.length = 0;


return;

}

gdjs['loseCode'] = gdjs.loseCode;
