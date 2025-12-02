gdjs.WinCode = {};
gdjs.WinCode.localVariables = [];
gdjs.WinCode.GDMergedFullBackgroundObjects1= [];
gdjs.WinCode.GDMergedFullBackgroundObjects2= [];
gdjs.WinCode.GDPlayButtonObjects1= [];
gdjs.WinCode.GDPlayButtonObjects2= [];
gdjs.WinCode.GDMenang_9595derObjects1= [];
gdjs.WinCode.GDMenang_9595derObjects2= [];
gdjs.WinCode.GDagain_9595derObjects1= [];
gdjs.WinCode.GDagain_9595derObjects2= [];


gdjs.WinCode.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("PlayButton"), gdjs.WinCode.GDPlayButtonObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.WinCode.GDPlayButtonObjects1.length;i<l;++i) {
    if ( gdjs.WinCode.GDPlayButtonObjects1[i].getBehavior("ButtonFSM").IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.WinCode.GDPlayButtonObjects1[k] = gdjs.WinCode.GDPlayButtonObjects1[i];
        ++k;
    }
}
gdjs.WinCode.GDPlayButtonObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "FullSokobanGame", false);
}}

}


};

gdjs.WinCode.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.WinCode.GDMergedFullBackgroundObjects1.length = 0;
gdjs.WinCode.GDMergedFullBackgroundObjects2.length = 0;
gdjs.WinCode.GDPlayButtonObjects1.length = 0;
gdjs.WinCode.GDPlayButtonObjects2.length = 0;
gdjs.WinCode.GDMenang_9595derObjects1.length = 0;
gdjs.WinCode.GDMenang_9595derObjects2.length = 0;
gdjs.WinCode.GDagain_9595derObjects1.length = 0;
gdjs.WinCode.GDagain_9595derObjects2.length = 0;

gdjs.WinCode.eventsList0(runtimeScene);
gdjs.WinCode.GDMergedFullBackgroundObjects1.length = 0;
gdjs.WinCode.GDMergedFullBackgroundObjects2.length = 0;
gdjs.WinCode.GDPlayButtonObjects1.length = 0;
gdjs.WinCode.GDPlayButtonObjects2.length = 0;
gdjs.WinCode.GDMenang_9595derObjects1.length = 0;
gdjs.WinCode.GDMenang_9595derObjects2.length = 0;
gdjs.WinCode.GDagain_9595derObjects1.length = 0;
gdjs.WinCode.GDagain_9595derObjects2.length = 0;


return;

}

gdjs['WinCode'] = gdjs.WinCode;
