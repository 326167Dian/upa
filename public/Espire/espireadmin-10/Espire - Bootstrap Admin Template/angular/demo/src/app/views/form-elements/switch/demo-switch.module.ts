import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { SwitchSectionComponent } from './switch-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { SwitchModule } from '@app/shared/components/switch/switch.module';
import { routes } from './demo-switch.routes';


@NgModule({
  declarations: [
    SwitchSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    SwitchModule,
    RouterModule.forChild(routes)
  ],
  exports: [SwitchSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoSwitchModule {
  static routes: any = routes;
}
