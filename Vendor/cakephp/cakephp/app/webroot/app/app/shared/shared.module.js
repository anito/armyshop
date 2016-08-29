"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('@angular/core');
var common_1 = require('@angular/common');
var forms_1 = require('@angular/forms');
var awesome_pipe_1 = require('./awesome.pipe');
var highlight_directive_1 = require('./highlight.directive');
var title_component_1 = require('./title.component');
var user_service_1 = require('./user.service');
var SharedModule = (function () {
    function SharedModule() {
    }
    SharedModule.forRoot = function () {
        return {
            ngModule: SharedModule,
            providers: [user_service_1.UserService]
        };
    };
    SharedModule = __decorate([
        core_1.NgModule({
            imports: [common_1.CommonModule],
            declarations: [awesome_pipe_1.AwesomePipe, highlight_directive_1.HighlightDirective, title_component_1.TitleComponent],
            exports: [awesome_pipe_1.AwesomePipe, highlight_directive_1.HighlightDirective, title_component_1.TitleComponent,
                common_1.CommonModule, forms_1.FormsModule]
        }), 
        __metadata('design:paramtypes', [])
    ], SharedModule);
    return SharedModule;
}());
exports.SharedModule = SharedModule;
var SharedRootModule = (function () {
    function SharedRootModule() {
    }
    SharedRootModule = __decorate([
        core_1.NgModule({
            exports: [SharedModule],
            providers: [user_service_1.UserService]
        }), 
        __metadata('design:paramtypes', [])
    ], SharedRootModule);
    return SharedRootModule;
}());
exports.SharedRootModule = SharedRootModule;
/*
Copyright 2016 Google Inc. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at http://angular.io/license
*/ 
//# sourceMappingURL=shared.module.js.map