import { DemoInputTypeComponent } from './demos/type/type';
import { DemoInputSizingComponent } from './demos/sizing/sizing';
import { DemoInputDisabledComponent } from './demos/disabled/disabled';
import { DemoInputColorComponent } from'./demos/color/color';
import { DemoInputGroupComponent } from './demos/group/group';
import { DemoInputWrappingComponent } from './demos/wrapping/wrapping';
import { DemoInputCheckboxRadioComponent } from './demos/checkbox-radio/checkbox-radio';
import { DemoInputMultiComponent } from './demos/multi/multi';
import { DemoInputAddonsComponent } from './demos/addons/addons';
import { DemoInputButtonComponent } from './demos/button/button';
import { DemoInputDropdownComponent } from './demos/dropdown/dropdown';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Form Control',
        anchor: 'form-control',
        description: `<p>Give textual form controls like <code>&lt;input&gt;</code>s and <code>&lt;textarea&gt;</code>s an upgrade with custom styles, sizing, focus states, and more.</p>`,
        html: require('!!raw-loader!./demos/type/type.html'),
        outlet: DemoInputTypeComponent
      },
      {
        title: 'Sizing',
        anchor: 'sizing',
        description: `<p>Set input heights by using <code>size</code></p>`,
        html: require('!!raw-loader!./demos/sizing/sizing.html'),
        outlet: DemoInputSizingComponent
      },
      {
        title: 'Disabled',
        anchor: 'disabled',
        description: `<p>Add <code>disabled</code> on input to prevent modification of the input’s value</p>`,
        html: require('!!raw-loader!./demos/disabled/disabled.html'),
        outlet: DemoInputDisabledComponent
      },
      {
        title: 'Color',
        anchor: 'color',
        description: `<p>Color picker input</p>`,
        html: require('!!raw-loader!./demos/color/color.html'),
        outlet: DemoInputColorComponent
      },
      {
        title: 'Input Group',
        anchor: 'group',
        description: `<p>Place one add-on or button on either side of an input. You may also place one on both sides of an input. </p>`,
        html: require('!!raw-loader!./demos/group/group.html'),
        outlet: DemoInputGroupComponent
      },
      {
        title: 'Wrapping',
        anchor: 'wrapping',
        description: `<p>Input groups wrap by default via <code>flex-wrap: wrap</code> in order to accommodate custom form field validation within an input group. You may disable this with <code>.flex-nowrap</code>.</p>`,
        html: require('!!raw-loader!./demos/wrapping/wrapping.html'),
        outlet: DemoInputWrappingComponent
      },
      {
        title: 'Checkboxes and radios',
        anchor: 'checkbox-radio',
        description: `<p>Place any checkbox or radio option within an input group’s addon instead of text.</p>`,
        html: require('!!raw-loader!./demos/checkbox-radio/checkbox-radio.html'),
        outlet: DemoInputCheckboxRadioComponent
      },
      {
        title: 'Multiple inputs',
        anchor: 'multi',
        description: `<p>While multiple <code>&lt;input&gt;</code>s are supported visually, validation styles are only available for input groups with a single <code>&lt;input&gt;</code>.</p>`,
        html: require('!!raw-loader!./demos/multi/multi.html'),
        outlet: DemoInputMultiComponent
      },
      {
        title: 'Multiple addons',
        anchor: 'addons',
        description: `<p>Multiple add-ons are supported and can be mixed with checkbox and radio input versions.</p>`,
        html: require('!!raw-loader!./demos/addons/addons.html'),
        outlet: DemoInputAddonsComponent
      },
      {
        title: 'Button addons',
        anchor: 'button',
        description: ``,
        html: require('!!raw-loader!./demos/button/button.html'),
        outlet: DemoInputButtonComponent
      },
      {
        title: 'Buttons with dropdowns',
        anchor: 'dropdown',
        description: ``,
        html: require('!!raw-loader!./demos/dropdown/dropdown.html'),
        outlet: DemoInputDropdownComponent
      }
    ]
  }
];
