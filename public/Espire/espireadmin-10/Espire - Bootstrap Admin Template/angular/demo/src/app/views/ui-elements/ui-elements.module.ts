import { NgModule } from '@angular/core';
import { UiElementsRoutingModule } from './ui-elements.routing.module';
import { NgApiDoc } from '@app/shared/components/docs/api-docs/api-docs.model';
import { ngdoc } from '@app/shared/components/docs/api-docs/ng-api-doc';
@NgModule({
  imports: [
    UiElementsRoutingModule
  ],
  providers: [{ provide: NgApiDoc, useValue: ngdoc }]
})
export class UiElementsModule {}