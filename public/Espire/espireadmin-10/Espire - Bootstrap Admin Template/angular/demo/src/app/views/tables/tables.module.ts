import { NgModule } from '@angular/core';
import { TablesRoutingModule } from './tables.routing.module';
import { NgApiDoc } from '@app/shared/components/docs/api-docs/api-docs.model';
import { ngdoc } from '@app/shared/components/docs/api-docs/ng-api-doc';

@NgModule({
  imports: [
    TablesRoutingModule
  ],
  providers: [{ provide: NgApiDoc, useValue: ngdoc }]
})
export class TablesModule {}