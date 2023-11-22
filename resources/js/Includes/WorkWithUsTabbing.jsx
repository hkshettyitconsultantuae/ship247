import { TabPanel, useTabs } from "react-headless-tabs";
import TabSelector from "./TabSelector";

export function WorkWithUsTabbing() {
  const [selectedTab, setSelectedTab] = useTabs([
    "insurance",
    "shipment",
    "clearance",
    "transporter",
  ]);

  return (
    <div className="primary-bg mb-20">
        <section className="max-w-screen-4xl mx-auto">
            <div className="default-container xl:flex gap-10">
                <div className="xl:w-3/12">
                    <h2 className="default-heading white xl:pt-20 pt-10">
                        SIGNUP AS
                    </h2>

                    <nav className="flex flex-col text-white TabSelector">
                        <TabSelector
                        isActive={selectedTab === "insurance"}
                        onClick={() => setSelectedTab("insurance")} className="active"
                        >
                        Insurance
                        </TabSelector>
                        <TabSelector
                        isActive={selectedTab === "shipment"}
                        onClick={() => setSelectedTab("shipment")}
                        >
                        PRE Shipment INSPECTION
                        </TabSelector>
                        <TabSelector
                        isActive={selectedTab === "clearance"}
                        onClick={() => setSelectedTab("clearance")}
                        >
                        Clearance Agent
                        </TabSelector>
                        <TabSelector
                        isActive={selectedTab === "transporter"}
                        onClick={() => setSelectedTab("transporter")}
                        >
                        Transporter
                        </TabSelector>
                    </nav>
                </div>

                <div className="xl:w-9/12 xl:mt-0 mt-10">
                    <TabPanel hidden={selectedTab !== "insurance"}>
                        <div className="item">
                            <div className="flex md:flex-row flex-col md:gap-20 gap-14">
                                <div className="flex items-start justify-center flex-col md:w-6/12 xl:my-20">
                                    <h4 className="default-subheading white mb-6">
                                    insurance
                                    </h4>
                                    <p className="default-content white">
                                        Ensures that all shipments comply with import and export regulations, such as tariffs, duties, and taxes. This can help businesses avoid legal and financial penalties and maintain compliance with the law.
                                        <br /><br />
                                        Efficient customs clearance can speed up the delivery process, ensuring that shipments reach their destination as quickly as possible.
                                        <br /><br />
                                        Customs clearance is necessary to ship goods internationally, allowing businesses to access new markets and expand their customer base. This can help businesses grow their business and increase their revenue.
                                    </p>

                                    <a href="/work-with-us-form" className="default-button-v2 md:mt-16 mt-10">
                                        <span>sign up</span>
                                    </a>
                                </div>

                                <div className="image-holder md:w-6/12 ml-auto h-auto">
                                    <img src="/images/insurance-signup.jpg" alt="" className="object-cover h-full rounded-xl" />
                                </div>
                            </div>
                        </div>
                    </TabPanel>

                    <TabPanel hidden={selectedTab !== "shipment"}>
                        <div className="item">
                            <div className="flex md:flex-row flex-col md:gap-20 gap-14">
                                <div className="flex items-start justify-center flex-col md:w-6/12 xl:my-20">
                                    <h4 className="default-subheading white mb-6">
                                    PRE Shipment INSPECTION
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="/work-with-us-form" className="default-button-v2 md:mt-16 mt-10">
                                        <span>sign up</span>
                                    </a>
                                </div>

                                <div className="image-holder md:w-6/12 ml-auto h-auto">
                                    <img src="/images/inspection-signup.jpg" alt="" className="object-cover h-full rounded-xl" />
                                </div>
                            </div>
                        </div>
                    </TabPanel>

                    <TabPanel hidden={selectedTab !== "clearance"}>
                        <div className="item">
                            <div className="flex md:flex-row flex-col md:gap-20 gap-14">
                                <div className="flex items-start justify-center flex-col md:w-6/12 xl:my-20">
                                    <h4 className="default-subheading white mb-6">
                                    Clearance Agent
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="/work-with-us-form" className="default-button-v2 md:mt-16 mt-10">
                                        <span>sign up</span>
                                    </a>
                                </div>

                                <div className="image-holder md:w-6/12 ml-auto h-auto">
                                    <img src="/images/clearance-signup.jpg" alt="" className="object-cover h-full rounded-xl" />
                                </div>
                            </div>
                        </div>
                    </TabPanel>

                    <TabPanel hidden={selectedTab !== "transporter"}>
                        <div className="item">
                            <div className="flex md:flex-row flex-col md:gap-20 gap-14">
                                <div className="flex items-start justify-center flex-col md:w-6/12 xl:my-20">
                                    <h4 className="default-subheading white mb-6">
                                    Transporter
                                    </h4>
                                    <p className="default-content white">
                                        Help ensure that shipments are of the expected quality, verifying that goods are in good condition, packed correctly, and comply with relevant regulations and industry standards. This can help businesses avoid costly mistakes, such as shipping damaged or non-compliant goods.
                                        <br /><br />
                                        Surveyor services can help identify and manage risks associated with shipping, such as cargo damage, theft, or loss. By assessing risks and implementing appropriate measures to mitigate them, businesses can reduce the likelihood of incidents and minimize the impact of any issues that do occur.
                                    </p>

                                    <a href="/work-with-us-form" className="default-button-v2 md:mt-16 mt-10">
                                        <span>sign up</span>
                                    </a>
                                </div>

                                <div className="image-holder md:w-6/12 ml-auto h-auto">
                                    <img src="/images/transporter-signup.jpg" alt="" className="object-cover h-full rounded-xl" />
                                </div>
                            </div>
                        </div>
                    </TabPanel>
                </div>

            </div>
        </section>
    </div>
    );
}

export default WorkWithUsTabbing;
