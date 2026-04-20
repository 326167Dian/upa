import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { SelectSectionComponent } from './select-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { NgSelectModule } from '@ng-select/ng-select';

import { routes } from './demo-select.routes';

@NgModule({
  declarations: [
    SelectSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    NgSelectModule,
    RouterModule.forChild(routes)
  ],
  exports: [SelectSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoSelectModule {
  static routes: any = routes;
}
