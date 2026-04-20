import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { FormSectionComponent } from './form-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { CheckboxModule } from '@app/shared/components/checkbox/checkbox.module';
import { RadioModule } from '@app/shared/components/radio/radio.module';
import { NgSelectModule } from '@ng-select/ng-select';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';

import { routes } from './demo-form.routes';

@NgModule({
  declarations: [
    FormSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    CheckboxModule,
    RadioModule,
    NgSelectModule,
    NgBootstrapFormValidationModule,
    NgBootstrapFormValidationModule.forRoot(),
    RouterModule.forChild(routes)
  ],
  exports: [FormSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoFormModule {
  static routes: any = routes;
}
