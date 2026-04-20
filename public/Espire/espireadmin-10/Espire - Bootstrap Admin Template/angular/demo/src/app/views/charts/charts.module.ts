import { NgModule } from '@angular/core';
import { ChartRoutingModule } from './charts.routing.module';
import { NgApiDoc } from '@app/shared/components/docs/api-docs/api-docs.model';
import { ngdoc } from '@app/shared/components/docs/api-docs/ng-api-doc';

@NgModule({
  imports: [
    ChartRoutingModule
  ],
  providers: [{ provide: NgApiDoc, useValue: ngdoc }]
})
export class ChartsModule {}