import className from "classnames/bind";
import style from "./Dashboard.module.scss";
import { useState, useEffect } from "react";
import Btn from "../../components/Button/Btn";
import Header from "../../components/Header/Header";

const cx = className.bind(style);
function Dashboard() {
    const [viewportWidth, setViewportWidth] = useState(window.innerWidth);
    useEffect(() => {
        function handleResize() {
            setViewportWidth(window.innerWidth);
        }
        window.addEventListener("resize", handleResize);
        handleResize();
        return () => {
            window.removeEventListener("resize", handleResize);
        };
    }, []);
    return (
        <div className={cx("main-container")}>
            <Header className={cx("header")} />

            <div
                style={{
                    width:
                        (viewportWidth / 100) * 18 > 220
                            ? "82vw"
                            : viewportWidth - 220 + "px",
                }}
                className={cx("dashboard")}
            >
                <div className={cx("heading")}>
                    <h1 className={cx("heading-title")}>dashboard</h1>
                    <img
                        src={require("../../assets/img/separator.png")}
                        alt="spr"
                    />
                </div>
                <div className={cx("box-container")}>
                    <div className={cx("box")}>
                        <h3 className={cx("box-title")}>Welcome !</h3>
                        <p>User Name</p> {/*fetch_profile['name'] */}
                        <Btn
                            value={"update profile"}
                            width={"fit-content"}
                        ></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select mesage from db*/}
                        <h3 className={cx("box-title")}>
                            23{/*Number of message */}
                        </h3>
                        <p>unread message</p>

                        <Btn value={"see message"} width={"fit-content"}></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/* select product from db*/}
                        <h3 className={cx("box-title")}>
                            23{/*Number of product */}
                        </h3>

                        <p>products added</p>
                        <Btn value={"add product"} width={"fit-content"}></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/* select active product from db*/}
                        <h3 className={cx("box-title")}>
                            20{/*Number of active product */}
                        </h3>

                        <p>Total active products</p>

                        <Btn
                            value={"View active product"}
                            width={"fit-content"}
                        ></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/* select deactive product from db*/}
                        <h3 className={cx("box-title")}>
                            0{/*Number of deactive product */}
                        </h3>

                        <p>products added</p>

                        <Btn
                            value={"Total inactive products"}
                            width={"fit-content"}
                        ></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select users from db*/}
                        <h3 className={cx("box-title")}>
                            0{/*Number of users */}
                        </h3>
                        <p>users account</p>
                        <Btn value={"see users"} width={"fit-content"}></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select sellers from db*/}
                        <h3 className={cx("box-title")}>
                            2{/*Number of sellers */}
                        </h3>
                        <p>sellers account</p>
                        <Btn value={"see sellers"} width={"fit-content"}></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select orders from db*/}
                        <h3 className={cx("box-title")}>
                            2{/*Number of orders */}
                        </h3>
                        <p>total orders placed</p>

                        <Btn value={"total orders"} width={"fit-content"}></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select confirm orders from db*/}
                        <h3 className={cx("box-title")}>
                            2{/*Number of confirm orders */}
                        </h3>
                        <p>total confirm orders </p>

                        <Btn
                            value={"confirm orders"}
                            width={"fit-content"}
                        ></Btn>
                    </div>
                    <div className={cx("box")}>
                        {/*select canceled orders from db*/}
                        <h3 className={cx("box-title")}>
                            2{/*Number of canceled orders */}
                        </h3>
                        <p>total canceled orders </p>

                        <Btn
                            value={"canceled orders"}
                            width={"fit-content"}
                        ></Btn>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Dashboard;
