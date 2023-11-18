import { computed } from "vue";

declare interface Advantages {
  title: string;
  description: string;
  icon: string;
}

export const advantages = computed<Advantages[]>(() => [
  {
    title: 'Transparency and Information access',
    description: 'Consumers access transparent information on raw material origins, fostering trust and informed choices',
    icon: 'bi:transparency'
  },
  {
    title: 'Ethical response',
    description: 'For those with ethical concerns, a traceability platform enables the selection of products aligned with their values',
    icon: 'ic:baseline-done'
  },
  {
    title: 'Environmental Sustainability',
    description: 'Choosing products from sustainable sources reduces the environmental impact of the textile industry.',
    icon: 'streamline:nature-ecology-leaf-protect-environment-leaf-ecology-plant-plants-eco'
  },
  {
    title: 'Reputation Enhancement',
    description: "Transparency reinforces the company's reputation, showcasing dedication to ethical and sustainable practices, fostering increased customer loyalty",
    icon: 'eos-icons:trusted-organization'
  },
  {
    title: 'Market Trend Responsiveness',
    description: 'Companies embracing social and environmental responsibility trends are strategically poised to anticipate and respond to market developments.',
    icon: 'system-uicons:graph-increase'
  },
  {
    title: 'Credibility for Partnerships',
    description: 'Traceability enhances company credibility, streamlining the establishment of strategic partnerships with organizations sharing common values',
    icon: 'codicon:workspace-trusted'
  }
])