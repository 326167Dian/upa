import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { CheckboxSectionComponent } from './checkbox-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { CheckboxModule } from '@app/shared/components/checkbox/checkbox.module';

import { routes } from './demo-checkbox.routes';

@NgModule({
  declarations: [
    CheckboxSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    CheckboxModule,
    RouterModule.forChild(routes)
  ],
  exports: [CheckboxSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoCheckboxModule {
  static routes: any = routes;
}
