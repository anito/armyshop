import { NgModule,
         ModuleWithProviders } from '@angular/core';
import { CommonModule }        from '@angular/common';
import { DeprecatedFormsModule }         from '@angular/common';

import { AwesomePipe }         from './awesome.pipe';
import { HighlightDirective }  from './highlight.directive';
import { TitleComponent }      from './title.component';
import { UserService }         from './user.service';

@NgModule({
  imports:      [ CommonModule ],
  declarations: [ AwesomePipe, TitleComponent ],
  exports:      [ AwesomePipe, TitleComponent,
    CommonModule, DeprecatedFormsModule ]
})
export class SharedModule {

  static forRoot(): ModuleWithProviders {
    return {
      ngModule: SharedModule,
      providers: [ UserService ]
    };
  }
}


@NgModule({
  exports:   [ SharedModule ],
  providers: [ UserService ]
})
export class SharedRootModule { }


/*
Copyright 2016 Google Inc. All Rights Reserved.
Use of this source code is governed by an MIT-style license that
can be found in the LICENSE file at http://angular.io/license
*/