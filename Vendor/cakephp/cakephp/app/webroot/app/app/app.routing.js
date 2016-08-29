"use strict";
var router_1 = require('@angular/router');
exports.routes = [
    { path: '', redirectTo: 'contact', pathMatch: 'full' },
    { path: 'crisis', loadChildren: 'app/crisis/crisis.module' },
    { path: 'heroes', loadChildren: 'app/hero/hero.module' }
];
exports.routing = router_1.RouterModule.forRoot(exports.routes);
/*
Copyright 2016 Google Inc. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at http://angular.io/license
*/ 
//# sourceMappingURL=app.routing.js.map