import { NgModule } from '@angular/core';
import { MapsRoutingModule } from './maps.routing.module';
import { NgApiDoc } from '@app/shared/components/docs/api-docs/api-docs.model';
import { ngdoc } from '@app/shared/components/docs/api-docs/ng-api-doc';

@NgModule({
  imports: [
    MapsRoutingModule
  ],
  providers: [{ provide: NgApiDoc, useValue: ngdoc }]
})
export class MapsModule {}