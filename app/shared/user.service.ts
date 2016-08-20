// Crazy copy of the app/user.service
// Proves that UserService is an app-wide singleton and only instantiated once
// IFF shared.module follows the `forRoot` pattern
//
// If it didn't, a new instance of UserService would be created
// after each lazy load and the userName would double up.

import { Injectable } from '@angular/core';

@Injectable()
export class UserService {

  static userName = '';

  constructor() {
    UserService.userName += UserService.userName || 'Sam Spade';
  }

  get userName() { return UserService.userName; }
}


/*
Copyright 2016 Google Inc. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at http://angular.io/license
*/