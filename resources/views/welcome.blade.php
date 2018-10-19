<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <style>
    </style>
</head>
<body>
<div id="app">
    <layout>

        <layout>
            <sider hide-trigger collapsible :collapsed-width="78"
                   :style="{position: 'fixed', height: '100vh', left: 0, overflow: 'auto'}">
                <div style="height:64px;color:#F0F0F0;text-align: center;padding:20px">LOGO</div>
                <i-menu @on-select="menu" theme="dark" width="auto">
                    <submenu name="survey">
                        <template slot="title">
                            <icon type="ios-navigate"></icon>
                            Survey
                        </template>
                        <menu-item name="plan" >Plan</menu-item>
                        <menu-item name="analysis">Analysis</menu-item>
                    </submenu>

                </i-menu>
            </sider>
            <layout style="padding-left:200px;min-height:100vh">
                {{--<i-header :style="{padding: 0, background:'#F0F0F0'}">--}}
                {{--</i-header>--}}
                <i-content :style="{padding: '24px', background: '#fff'}">
                    <div>
                        <div>
                            <button-group>
                                <i-button>Current</i-button>
                                <i-button>Finished</i-button>
                                <i-button>...</i-button>
                            </button-group>
                        </div>
                        <div>
                            <table class="table">
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </i-content>
            </layout>

        </layout>
        {{--<i-footer>@copyright</i-footer>--}}
    </layout>
</div>
</body>
<script src="{{asset('js/app.js')}}"></script>
<script>
    const app = new Vue({
        el: '#app',
        data : {

        },
        created : function(){

        },
        methods : {
            menu : function(name){
                console.log("menu selected")
                console.log(name)
            }
        }
    });
</script>
</html>